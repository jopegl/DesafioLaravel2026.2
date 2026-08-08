<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function create(User $user): bool
    {
        return !$user->is_admin;
    }

    public function update(User $user, Product $product): bool
    {
        return $user->id == $product->user_id || $user->is_admin;
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->id == $product->user_id || $user->is_admin;
    }
}
