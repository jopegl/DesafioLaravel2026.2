<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'nome',
        'foto',
        'descricao',
        'preco',
        'quantidade',
    ];

    protected function casts(): array
    {
        return [
            'preco' => 'decimal:2',
        ];
    }
}
