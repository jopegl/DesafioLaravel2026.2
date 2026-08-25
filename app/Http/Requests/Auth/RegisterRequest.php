<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Rules\Cpf;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')],
            'cpf'        => ['required', 'string', 'size:11', Rule::unique('users', 'cpf'), new Cpf],
            'phone'      => ['required', 'string', 'min:10', 'max:11'],
            'birth_date' => ['required', 'date', 'before:today'],
            'password'   => ['required', 'confirmed', Password::defaults()],
        ];
    }

    protected function prepareForValidation(): void
    {
        $mergeData = [];

        if ($this->filled('cpf')) {
            $mergeData['cpf'] = preg_replace('/[^0-9]/', '', $this->cpf);
        }

        if ($this->filled('phone')) {
            $mergeData['phone'] = preg_replace('/[^0-9]/', '', $this->phone);
        }

        if (!empty($mergeData)) {
            $this->merge($mergeData);
        }
    }
}
