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
            'name'       => ['required', 'string', 'max:255'],
            'email'      => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone'      => ['required', 'string', 'digits_between:10,11'],
            'birth_date' => ['required', 'date', 'before:today'],
            'photo'      => ['nullable', 'image', 'max:2048'], // 2mb
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('phone')) {
            $this->merge([
                'phone' => preg_replace('/[^0-9]/', '', $this->phone),
            ]);
        }
    }

    public function messages(): array
    {
        return [
            'birth_date.before' => 'A data de nascimento deve ser anterior a hoje.',
            'photo.image'       => 'O arquivo deve ser uma imagem.',
            'photo.max'         => 'A imagem deve ter no máximo 2MB.',
        ];
    }
}
