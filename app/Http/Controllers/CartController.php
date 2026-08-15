<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $cartItems = $user->cartItems;
        $nProducts = $user->cartItemsCount();
        $total = $user->cartTotal();

        return view('cart.index', compact('cartItems', 'nProducts', 'total'));
    }

    public function store(StoreCartItemRequest $request)
    {
        $data = $request->validated();

        $cartItem = auth()->user()->cartItems()
            ->where('product_id', $data['product_id'])
            ->first();

        $product = Product::findOrFail($data['product_id']);
        $currentQty = $cartItem?->quantity ?? 0;

        if ($currentQty + $data['quantity'] > $product->quantity) {
            return back()->with('error', 'Quantidade solicitada indisponível em estoque.');
        }

        if ($cartItem) {
            $cartItem->increment('quantity', $data['quantity']);
        } else {
            auth()->user()->cartItems()->create($data);
        }

        return back()->with('success', 'Produto adicionado ao carrinho!');
    }

    public function update(UpdateCartItemRequest $request, CartItem $cartItem)
    {

        $data = $request->validated();

        if ($data['quantity'] > $cartItem->product->quantity) {
            return back()->with('error', 'Quantidade solicitada indisponível em estoque.');
        }

        $cartItem->update($data);

        return back();
    }


    public function destroy(CartItem $cartItem)
    {
        $this->authorize('delete', $cartItem);
        $cartItem->delete();
        return redirect()->route('cart.index')->with('success', 'Item removido do carrinho.');
    }
}
