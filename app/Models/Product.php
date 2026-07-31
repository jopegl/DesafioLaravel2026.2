<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    public function scopeBuscar(Builder $query, ?string $termo): Builder
    {
        if (!$termo) {
            return $query;
        }

        return $query->where('nome', 'like', "%{$termo}%");
    }

    public function scopeDaCategoria(Builder $query, ?string $categoriaId): Builder
    {
        if (! $categoriaId) {
            return $query;
        }

        return $query->where('category_id', $categoriaId);
    }
}
