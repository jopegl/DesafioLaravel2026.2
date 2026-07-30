<?php

namespace App\Models;

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
            'valor_total' => 'decimal:2',
            'data_compra' => 'datetime',
        ];
    }
}
