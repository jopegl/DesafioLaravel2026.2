<?php

namespace App\Http\Requests;

use App\Rules\Cpf;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('user'));
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'cpf' => ['required', 'string', 'size:11', Rule::unique('users', 'cpf')->ignore($userId), new Cpf],
            'phone'      => ['required', 'string', 'max:20'],
            'birth_date' => ['required', 'date', 'before:today'],
            'photo'      => ['nullable', 'image', 'max:2048'],
            'password'   => ['nullable', 'confirmed', Password::defaults()],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (blank($this->password)) {
            $this->request->remove('password');
            $this->request->remove('password_confirmation');
        }

        if ($this->filled('cpf')) {
            $this->merge([
                'cpf' => preg_replace('/[^0-9]/', '', $this->cpf),
            ]);
        }
    }
}
