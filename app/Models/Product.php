<?php

namespace App\Models;

use GuzzleHttp\Psr7\Query;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'photo',
        'description',
        'price',
        'quantity',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }



    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (!$term) {
            return $query;
        }

        return $query->where('name', 'like', "%{$term}%");
    }

    public function scopeInCategory(Builder $query, ?string $categoryId): Builder
    {
        if (! $categoryId) {
            return $query;
        }

        return $query->where('category_id', $categoryId);
    }

    public function scopePriceBetween(Builder $query, ?string $priceMin, ?string $priceMax): Builder
    {
        if ($priceMin) {
            $query->where('price', '>=', $priceMin);
        }

        if ($priceMax) {
            $query->where('price', '<=', $priceMax);
        }

        return $query;
    }

    public function scopeInStock(Builder $query, ?string $inStock): Builder
    {
        if (!$inStock) {
            return $query;
        }

        return $query->where('quantity', '>', 0);
    }

    public function scopeSortBy(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'recent' => $query->orderBy('created_at', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };
    }

    public function scopeById(Builder $query, int $id)
    {
        if ($id < 0) {
            return $query;
        }
        return $query->where('id', $id);
    }

    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        return $user->is_admin
            ? $query
            : $query->where('user_id', $user->id);
    }

    public function scopeWithDetails(Builder $query): Builder
    {
        return $query->with(['category', 'user']);
    }
}
