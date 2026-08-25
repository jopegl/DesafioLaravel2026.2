<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'user_id'       => ['sometimes', 'integer', Rule::exists('users', 'id')],
            'zip_code'      => ['required', 'string', 'size:8'],
            'street'        => ['required', 'string', 'max:255'],
            'number'        => ['required', 'string', 'max:20'],
            'neighborhood'  => ['required', 'string', 'max:100'],
            'city'          => ['required', 'string', 'max:100'],
            'state'         => ['required', 'string', 'size:2'],
            'complement'    => ['nullable', 'string', 'max:255'],
            'is_default'    => ['sometimes', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (! $this->user()->is_admin) {
            $this->request->remove('user_id');
        }

        if ($this->filled('zip_code')) {
            $this->merge([
                'zip_code' => preg_replace('/[^0-9]/', '', $this->zip_code),
            ]);
        }
    }

    public function messages(): array
    {
        return [
            'zip_code.size'  => 'O CEP deve conter 8 dígitos (sem hífen).',
            'state.size'     => 'Informe a UF com 2 letras (ex: SP).',
            'user_id.exists' => 'Usuário não encontrado.',
        ];
    }
}
