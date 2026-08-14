<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\CartItem;
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

        return view('cart', compact('cartItems', 'nProducts', 'total'));
    }

    public function store(StoreCartItemRequest $request)
    {
        $data = $request->validated();
        $cartItem = auth()->user()->cartItems()
            ->where('product_id', $data['product_id'])
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $data['quantity']);
        } else {
            auth()->user()->cartItems()->create($data);
        }

        return back()->with('success', 'Produto adicionado ao carrinho!');
    }

    public function update(UpdateCartItemRequest $request, CartItem $cartItem)
    {
        $cartItem->update($request->validated());

        return back()->with('success', 'Quantidade atualizada!');
    }


    public function destroy(CartItem $cartItem)
    {
        $this->authorize('delete', $cartItem);
        $cartItem->delete();
        return redirect()->route('users.index')->with('success', 'Usuário criado.');
    }
}
