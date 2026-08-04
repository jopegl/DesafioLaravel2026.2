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

    public function scopePrecoEntre(Builder $query, ?string $precoMin, ?string $precoMax): Builder
    {
        if ($precoMin) {
            $query->where('preco', '>=', $precoMin);
        }

        if ($precoMax) {
            $query->where('preco', '<=', $precoMax);
        }

        return $query;
    }

    public function scopeEmEstoque(Builder $query, ?string $emEstoque): Builder
    {
        if (!$emEstoque) {
            return $query;
        }

        return $query->where('quantidade', '>', 0);
    }

    public function scopeOrdenar(Builder $query, ?string $ordenacao): Builder
    {
        return match ($ordenacao) {
            'menor_preco' => $query->orderBy('preco', 'asc'),
            'maior_preco' => $query->orderBy('preco', 'desc'),
            'recentes' => $query->orderBy('created_at', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };
    }

    public function scopePorId(Builder $query, int $id)
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
