<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PagBankController extends Controller
{
    protected string $baseUrl;
    protected string $token;

    public function __construct()
    {
        $this->token = config('services.pagbank.token');

        $this->baseUrl = config('services.pagbank.sandbox')
            ? 'https://sandbox.api.pagseguro.com'
            : 'https://api.pagseguro.com';
    }

    protected function headers(): array
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
                // PagBank trabalha em centavos, diferente do Mercado Pago
                'unit_amount' => (int) round($item->product->price * 100),
            ];
        })->toArray();

        $referenceId = (string) \Illuminate\Support\Str::uuid();

        $response = Http::withHeaders($this->headers())->post("{$this->baseUrl}/checkouts", [
            'reference_id' => $referenceId,
            'items' => $items,
            'customer_modifiable' => true,
            'redirect_url' => route('pagbank.callback', ['reference_id' => $referenceId]),
            'notification_urls' => [
                route('pagbank.webhook'),
            ],
        ]);

        if ($response->failed()) {
            Log::stack(['single', 'stderr'])->error('Erro ao criar checkout PagBank', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return back()->with('error', 'Não foi possível iniciar o pagamento.');
        }

        $checkout = $response->json();

        cache()->put("pagbank_checkout:{$referenceId}", $user->id, now()->addHours(3));

        $payLink = collect($checkout['links'] ?? [])->firstWhere('rel', 'PAY');

        if (!$payLink) {
            Log::stack(['single', 'stderr'])->error('Checkout PagBank sem link de pagamento', $checkout);

            return back()->with('error', 'Não foi possível iniciar o pagamento.');
        }

        return redirect($payLink['href']);
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

    protected function resolvePaymentStatus(array $checkout): string
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
        $status = $payload['status'] ?? null;

        if (!in_array($status, ['PAID', 'DECLINED', 'CANCELED'], true)) {
            return response()->json(['status' => 'ignored'], 200);
        }

        $checkoutId = $payload['id'] ?? null;
        $referenceId = $payload['reference_id'] ?? null;

        if (!$checkoutId || !$referenceId) {
            return response()->json(['error' => 'missing identifiers'], 400);
        }

        if (Sale::where('pagbank_checkout_id', $checkoutId)->exists()) {
            return response()->json(['status' => 'already processed'], 200);
        }

        if ($status !== 'PAID') {
            return response()->json(['status' => 'not paid'], 200);
        }

        $buyerId = cache()->get("pagbank_checkout:{$referenceId}");
        $buyer = $buyerId ? User::find($buyerId) : null;

        if (!$buyer) {
            Log::stack(['single', 'stderr'])->error('Comprador não encontrado para checkout PagBank', [
                'reference_id' => $referenceId,
            ]);

            return response()->json(['error' => 'buyer not found'], 404);
        }

        $cartItems = $buyer->cartItems()->with('product')->get();

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
        cache()->forget("pagbank_checkout:{$referenceId}");

        return response()->json(['status' => 'ok'], 200);
    }

    protected function isAuthentic(Request $request): bool
    {
        $header = $request->header('x-authenticity-token');

        if (!$header) {
            return false;
        }

        $expected = hash('sha256', "{$this->token}-{$request->getContent()}");

        return hash_equals($expected, $header);
    }
}
