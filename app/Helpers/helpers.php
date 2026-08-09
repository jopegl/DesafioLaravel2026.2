<?php

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

if (! function_exists('formatPrice')) {

    function formatPrice(float $value): string
    {
        return 'R$' . number_format($value, 2, ',', '.');
    }
}

if (! function_exists('productInStock')) {
    function productInStock(Product $product): bool
    {
        return $product->quantity > 0;
    }
}

if (! function_exists('productPhotoUrl')) {
    function productPhotoUrl(?string $photo): string
    {
        return $photo && Storage::disk('public')->exists($photo)
            ? asset('storage/' . $photo)
            : asset('images/placeholder-produto.png');
    }
}

if (! function_exists('userPhotoUrl')) {

    function userPhotoUrl(?string $photo): string
    {
        return $photo && Storage::disk('public')->exists($photo)
            ? asset('storage/' . $photo)
            : asset('images/placeholder-user.png');
    }
}
