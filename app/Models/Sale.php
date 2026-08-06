<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'buyer_id',
        'seller_id',
        'category_id',
        'quantidade',
        'valor_unitario',
        'valor_total',
        'data_compra',
    ];

    protected function casts(): array
    {
        return [
            'valor_unitario' => 'decimal:2',
            'valor_total'    => 'decimal:2',
            'data_compra'    => 'datetime',
        ];
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function scopeAsSeller(Builder $query, User $user): Builder
    {
        return $user->is_admin
            ? $query
            : $query->where('seller_id', $user->id);
    }

    public function scopeAsBuyer(Builder $query, User $user): Builder
    {
        return $user->is_admin
            ? $query
            : $query->where('buyer_id', $user->id);
    }

    public function scopeWithDetails(Builder $query): Builder
    {
        return $query->with(['product', 'buyer', 'seller', 'category']);
    }


    public function scopePeriodo(Builder $query, ?string $inicio, ?string $fim): Builder
    {
        if ($inicio) {
            $query->where('data_compra', '>=', $inicio);
        }

        if ($fim) {
            $query->where('data_compra', '<=', $fim);
        }

        return $query;
    }
}
