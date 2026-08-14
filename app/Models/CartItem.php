<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'quantity'];


    public function user()
    {
        return  $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


    public function scopeForUser(Builder $query, User $user)
    {

        return $query->where('user_id', $user->id);
    }
}
