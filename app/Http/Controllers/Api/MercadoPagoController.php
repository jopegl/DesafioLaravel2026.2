<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use function PHPUnit\Framework\isEmpty;

class MercadoPagoController extends Controller
{
    public function process()
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Seu carrinho está vazio.');
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

        $response = Http::withToken(config('services.mercadopago.access_token'))
            ->post('https://api.mercadopago.com/checkout/preferences', [
                'items' => $items,
                'back_urls' => [
                    'success' => route('mercadopago.success'),
                    'pending' => route('mercadopago.pending'),
                    'failure' => route('mercadopago.failure'),
                ],
                'auto_return' => 'approved',
                'notification_url' => route('mercadopago.webhook'),
                'external_reference' => (string) $user->id,
            ]);

        if ($response->failed()) {
            return back()->with('error', 'Não foi possível iniciar o pagamento.');
        }

        $preference = $response->json();

        return redirect($preference['sandbox_init_point']);
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

        if (Sale::where('mp_payment_id', $paymentId)->exists()) {
            return response()->json(['status' => 'already processed'], 200);
        }

        $response = Http::withToken(config('services.mercadopago.access_token'))
            ->get("https://api.mercadopago.com/v1/payments/{$paymentId}");

        if ($response->failed()) {
            return response()->json(['error' => 'failed to fetch payment'], 500);
        }

        $payment = $response->json();

        if ($payment['status'] !== 'approved') {
            return response()->json(['status' => 'not approved yet'], 200);
        }

        $buyerId = $payment['external_reference'];
        $buyer = User::find($buyerId);

        if (!$buyer) {
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
                'mp_payment_id' => $paymentId,
            ]);

            $product->user->increment('balance', $product->price * $item->quantity);
            $product->decrement('quantity', $item->quantity);
        }

        $buyer->cartItems()->delete();

        return response()->json(['status' => 'ok'], 200);
    }
}
