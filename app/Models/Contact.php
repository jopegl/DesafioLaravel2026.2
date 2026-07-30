<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nome',
        'email',
        'mensagem',
        'resposta',
        'respondido_por',
        'respondido_em',
    ];

    protected function casts(): array
    {
        return [
            'respondido_em' => 'datetime',
        ];
    }
}
