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
        'quantity',
        'unit_price',
        'total_price',
        'purchase_date',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'total_price'    => 'decimal:2',
            'purchase_date'    => 'datetime',
        ];
    }


    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id')->withTrashed();
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id')->withTrashed();
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
        return $query->where('buyer_id', $user->id);
    }

    public function scopeWithDetails(Builder $query): Builder
    {
        return $query->with(['product', 'buyer', 'seller', 'category']);
    }


    public function scopePeriod(Builder $query, ?string $start, ?string $end): Builder
    {
        if ($start) {
            $query->where('purchase_date', '>=', $start);
        }

        if ($end) {
            $query->where('purchase_date', '<=', $end);
        }

        return $query;
    }
}
