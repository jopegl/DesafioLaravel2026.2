<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'cpf'        => ['nullable', 'string', 'size:11', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone'      => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'photo'      => ['nullable', 'image', 'max:2048'], // 2mb
        ];
    }

    public function messages(): array
    {
        return [
            'cpf.size'          => 'O CPF deve conter 11 dígitos (sem pontuação).',
            'birth_date.before' => 'A data de nascimento deve ser anterior a hoje.',
            'photo.image'       => 'O arquivo deve ser uma imagem.',
            'photo.max'         => 'A imagem deve ter no máximo 2MB.',
        ];
    }
}
