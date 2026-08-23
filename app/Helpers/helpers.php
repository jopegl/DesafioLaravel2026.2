<?php

use App\Models\Product;
use Carbon\Carbon;
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

if (! function_exists('formatPhone')) {
    function formatPhone(?string $phone): string
    {
        if (empty($phone)) {
            return '-';
        }

        $digits = preg_replace('/\D/', '', $phone);

        return match (strlen($digits)) {
            11 => preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $digits),
            10 => preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $digits),
            13 => preg_replace('/(\d{2})(\d{2})(\d{5})(\d{4})/', '+$1 ($2) $3-$4', $digits),
            default => $phone
        };
    }
}

if (! function_exists('formatDate')) {

    function formatDate(string|Carbon|\DateTimeInterface|null $date): string
    {
        if (empty($date)) {
            return '-';
        }

        return Carbon::parse($date)->format('d/m/Y');
    }
}
