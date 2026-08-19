<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class PagBankController extends Controller
{
    private string $baseUrl;
    private string $token;

    public function __construct()
    {
        $this->token = config('services.pagbank.token');

        $this->baseUrl = config('services.pagbank.sandbox')
            ? 'https://sandbox.api.pagseguro.com'
            : 'https://api.pagseguro.com';
    }

    private function headers(): array
    {
        return [
            'Authorization' => "Bearer {$this->token}",
            'Content-Type' => 'application/json',
        ];
    }

    public function process()
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Seu carrinho está vazio.');
        }

        $items = $cartItems->map(function ($item) {
            return [
                'reference_id' => (string) $item->product_id,
                'name' => $item->product->name,
                'quantity' => $item->quantity,
                'unit_amount' => (int) round($item->product->price * 100),
            ];
        })->toArray();

        $referenceId = (string) \Illuminate\Support\Str::uuid();

        $response = Http::withHeaders($this->headers())->post("{$this->baseUrl}/checkouts", [
            'reference_id' => $referenceId,
            'items' => $items,
            'customer_modifiable' => true,
        ]);

        if ($response->failed()) {
            Log::stack(['single', 'stderr'])->error('Erro ao criar checkout PagBank', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return back()->with('error', 'Não foi possível iniciar o pagamento.');
        }

        $checkout = $response->json();

        $payLink = collect($checkout['links'] ?? [])->firstWhere('rel', 'PAY');

        if (!$payLink) {
            Log::stack(['single', 'stderr'])->error('Checkout PagBank sem link de pagamento', $checkout);

            return back()->with('error', 'Não foi possível iniciar o pagamento.');
        }

        // registra a venda no momento do clique, usando o id do checkout
        // (ainda não é confirmação de pagamento).
        $this->registerSale($user, $cartItems, (string) $checkout['id']);

        cache()->put("pagbank_checkout:{$referenceId}", $user->id, now()->addHours(3));

        return redirect($payLink['href']);
    }

    private function registerSale(User $buyer, Collection $cartItems, string $checkoutId): void
    {
        foreach ($cartItems as $item) {
            $product = $item->product;

            Sale::create([
                'product_id' => $product->id,
                'buyer_id' => $buyer->id,
                'seller_id' => $product->user_id,
                'category_id' => $product->category_id,
                'quantity' => $item->quantity,
                'unit_price' => $product->price,
                'total_price' => $product->price * $item->quantity,
                'purchase_date' => now(),
                'pagbank_checkout_id' => $checkoutId,
            ]);

            $product->user->increment('balance', $product->price * $item->quantity);
            $product->decrement('quantity', $item->quantity);
        }

        $buyer->cartItems()->delete();
    }

    public function callback(Request $request)
    {
        $referenceId = $request->query('reference_id');

        if (!$referenceId) {
            return redirect()->route('cart.index')->with('error', 'Pagamento não encontrado.');
        }

        $response = Http::withHeaders($this->headers())
            ->get("{$this->baseUrl}/checkouts", ['reference_id' => $referenceId]);

        if ($response->failed()) {
            Log::stack(['single', 'stderr'])->error('Erro ao consultar checkout PagBank', [
                'reference_id' => $referenceId,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return view('checkout.pending');
        }

        $status = $this->resolvePaymentStatus($response->json());

        return match ($status) {
            'PAID' => view('checkout.success'),
            'DECLINED', 'CANCELED' => view('checkout.failure'),
            default => view('checkout.pending'),
        };
    }

    private function resolvePaymentStatus(array $checkout): string
    {
        $charges = collect($checkout['charges'] ?? []);

        return $charges->last()['status'] ?? 'WAITING';
    }

    public function webhook(Request $request)
    {
        if (!$this->isAuthentic($request)) {
            Log::stack(['single', 'stderr'])->warning('Webhook PagBank com assinatura inválida');

            return response()->json(['error' => 'invalid signature'], 401);
        }

        $payload = $request->all();

        // a venda já foi registrada no clique do botão (process()).
        // aqui só logamos o status recebido, sem criar/alterar registros.
        Log::info('Notificação de pagamento PagBank recebida', [
            'id' => $payload['id'] ?? null,
            'reference_id' => $payload['reference_id'] ?? null,
            'status' => $payload['status'] ?? null,
        ]);

        return response()->json(['status' => 'ok'], 200);
    }

    private function isAuthentic(Request $request): bool
    {
        $header = $request->header('x-authenticity-token');

        if (!$header) {
            return false;
        }

        $expected = hash('sha256', "{$this->token}-{$request->getContent()}");

        return hash_equals($expected, $header);
    }
}
