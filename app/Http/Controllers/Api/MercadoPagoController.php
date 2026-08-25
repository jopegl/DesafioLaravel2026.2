<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;

class MercadoPagoController extends Controller
{
    public function __construct()
    {
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
    }

    public function process()
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Seu carrinho está vazio.');
        }

        if ($cartItems->contains(fn($item) => $item->product->user_id === $user->id)) {
            return back()->with('error', 'Você não pode comprar seu próprio produto.');
        }

        $items = $cartItems->map(function ($item) {
            return [
                'id' => (string) $item->product_id,
                'title' => $item->product->name,
                'quantity' => $item->quantity,
                'currency_id' => 'BRL',
                'unit_price' => (float) $item->product->price,
            ];
        })->toArray();

        $client = new PreferenceClient();

        try {
            $preference = $client->create([
                'items' => $items,
                'back_urls' => [
                    'success' => route('mercadopago.success'),
                    'pending' => route('mercadopago.pending'),
                    'failure' => route('mercadopago.failure'),
                ],
                'external_reference' => (string) $user->id,
            ]);
        } catch (MPApiException $e) {
            Log::stack(['single', 'stderr'])->error('Erro ao criar preferência MercadoPago', [
                'status' => $e->getApiResponse()->getStatusCode(),
                'body' => $e->getApiResponse()->getContent(),
            ]);

            return back()->with('error', 'Não foi possível iniciar o pagamento.');
        }

        // registra a venda no momento do clique, usando o id da preferência
        // (ainda não é o id do pagamento, pois o pagamento não ocorreu).
        $this->registerSale($user, $cartItems, (string) $preference->id);

        return redirect($preference->sandbox_init_point);
    }

    private function registerSale(User $buyer, Collection $cartItems, string $mpReferenceId): void
    {
        DB::transaction(function () use ($buyer, $cartItems, $mpReferenceId) {
            foreach ($cartItems as $item) {
                $product = $item->product;

                Sale::create([
                    'product_id'    => $product->id,
                    'buyer_id'      => $buyer->id,
                    'seller_id'     => $product->user_id,
                    'category_id'   => $product->category_id,
                    'quantity'      => $item->quantity,
                    'unit_price'    => $product->price,
                    'total_price'   => $product->price * $item->quantity,
                    'purchase_date' => now(),
                    'mp_payment_id' => $mpReferenceId,
                    'is_paid'       => true,
                ]);

                $product->user->increment('balance', $product->price * $item->quantity);
                $product->decrement('quantity', $item->quantity);
            }

            $buyer->cartItems()->delete();
        });
    }

    public function success()
    {
        return view('checkout.success');
    }

    public function pending()
    {
        return view('checkout.pending');
    }

    public function failure()
    {
        return view('checkout.failure');
    }

    public function webhook(Request $request)
    {
        if ($request->input('type') !== 'payment') {
            return response()->json(['status' => 'ignored'], 200);
        }

        $paymentId = $request->input('data.id');

        if (!$paymentId) {
            return response()->json(['error' => 'payment id missing'], 400);
        }

        $client = new PaymentClient();

        try {
            $payment = $client->get($paymentId);
        } catch (MPApiException $e) {
            Log::stack(['single', 'stderr'])->error('Erro ao buscar pagamento MercadoPago', [
                'payment_id' => $paymentId,
                'status' => $e->getApiResponse()->getStatusCode(),
                'body' => $e->getApiResponse()->getContent(),
            ]);

            return response()->json(['error' => 'failed to fetch payment'], 500);
        }

        // a venda já foi registrada no clique do botão (process()).
        // aqui só logamos o status recebido, sem criar/alterar registros.
        Log::info('Notificação de pagamento MercadoPago recebida', [
            'payment_id' => $paymentId,
            'status' => $payment->status,
            'external_reference' => $payment->external_reference,
        ]);

        return response()->json(['status' => 'ok'], 200);
    }
}
