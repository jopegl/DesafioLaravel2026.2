<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', CartItem::class);

        $user = Auth::user();

        $cartItems = $user->cartItems;
        $nProducts = $user->cartItemsCount();
        $total = $user->cartTotal();

        return view('cart.index', compact(
            'cartItems',
            'nProducts',
            'total'
        ));
    }

    public function store(StoreCartItemRequest $request)
    {
        $this->authorize('create', CartItem::class);

        $data = $request->validated();

        $product = Product::findOrFail($data['product_id']);

        if ($product->user_id === auth()->id()) {
            return back()->with(
                'error',
                'Não é possível adicionar seu próprio produto ao carrinho.'
            );
        }

        $cartItem = auth()->user()
            ->cartItems()
            ->where('product_id', $data['product_id'])
            ->first();

        $currentQty = $cartItem?->quantity ?? 0;

        if ($currentQty + $data['quantity'] > $product->quantity) {
            return back()->with(
                'error',
                'Quantidade solicitada indisponível em estoque.'
            );
        }

        if ($cartItem) {
            $cartItem->increment('quantity', $data['quantity']);
        } else {
            auth()->user()->cartItems()->create($data);
        }

        return redirect()->route('cart.index')->with('success', 'Produto adicionado ao carrinho!');
    }

    public function update(
        UpdateCartItemRequest $request,
        CartItem $cartItem
    ) {
        $this->authorize('update', $cartItem);

        $data = $request->validated();

        if ($data['quantity'] > $cartItem->product->quantity) {
            return back()->with(
                'error',
                'Quantidade solicitada indisponível em estoque.'
            );
        }

        $cartItem->update($data);

        return back()->with(
            'success',
            'Quantidade atualizada!'
        );
    }

    public function destroy(CartItem $cartItem)
    {
        $this->authorize('delete', $cartItem);

        $cartItem->delete();

        return redirect()
            ->route('cart.index')
            ->with('success', 'Item removido do carrinho.');
    }
}
