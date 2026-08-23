<?php

namespace App\Policies;

use App\Models\CartItem;
use App\Models\User;

class CartItemPolicy
{

    public function viewAny(User $user): bool
    {
        return !$user->is_admin;
    }


    public function view(User $user, CartItem $cartItem): bool
    {
        return !$user->is_admin
            && $user->id === $cartItem->user_id;
    }

    public function create(User $user): bool
    {
        return !$user->is_admin;
    }

    public function update(User $user, CartItem $cartItem): bool
    {
        return !$user->is_admin
            && $user->id === $cartItem->user_id;
    }

    public function delete(User $user, CartItem $cartItem): bool
    {
        return !$user->is_admin
            && $user->id === $cartItem->user_id;
    }
}
