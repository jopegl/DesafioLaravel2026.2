<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', User::class);
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'cpf'        => ['required', 'string', 'size:11', 'unique:users,cpf'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'photo'      => ['nullable', 'image', 'max:2048'], // 2MB
            'password'   => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'cpf.size'        => 'O CPF deve conter 11 dígitos (sem pontuação).',
            'email.unique'    => 'Este e-mail já está cadastrado.',
            'birth_date.before' => 'A data de nascimento deve ser anterior a hoje.',
            'photo.image'     => 'O arquivo deve ser uma imagem.',
            'photo.max'       => 'A imagem deve ter no máximo 2MB.',
        ];
    }
}
