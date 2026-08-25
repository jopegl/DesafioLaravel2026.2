<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\Cpf;
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
            'cpf'        => ['required', 'string', 'size:11', 'unique:users,cpf', new Cpf],
            'phone'      => ['required', 'string', 'digits_between:10,11'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'photo'      => ['nullable', 'image', 'max:2048'], // 2MB
            'password'   => ['required', 'confirmed', Password::defaults()],

            'address'                => ['nullable', 'array'],
            'address.zip_code'       => ['nullable', 'string', 'size:8'],
            'address.street'         => ['required_with:address.zip_code', 'nullable', 'string', 'max:255'],
            'address.number'         => ['required_with:address.zip_code', 'nullable', 'string', 'max:20'],
            'address.neighborhood'   => ['required_with:address.zip_code', 'nullable', 'string', 'max:100'],
            'address.city'           => ['required_with:address.zip_code', 'nullable', 'string', 'max:100'],
            'address.state'          => ['required_with:address.zip_code', 'nullable', 'string', 'size:2'],
            'address.complement'     => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {

        if ($this->filled('cpf')) {
            $this->merge([
                'cpf' => preg_replace('/[^0-9]/', '', $this->cpf),
            ]);
        }

        if ($this->filled('phone')) {
            $this->merge([
                'phone' => preg_replace('/[^0-9]/', '', $this->phone),
            ]);
        }

        if ($this->filled('address.zip_code')) {
            $this->merge([
                'address' => array_merge($this->address ?? [], [
                    'zip_code' => preg_replace('/[^0-9]/', '', $this->address['zip_code']),
                ]),
            ]);
        }
    }

    public function messages(): array
    {
        return [
            'cpf.size'           => 'O CPF deve conter 11 dígitos (sem pontuação).',
            'email.unique'       => 'Este e-mail já está cadastrado.',
            'birth_date.before'  => 'A data de nascimento deve ser anterior a hoje.',
            'photo.image'        => 'O arquivo deve ser uma imagem.',
            'photo.max'          => 'A imagem deve ter no máximo 2MB.',

            'address.zip_code.size'            => 'O CEP deve conter 8 dígitos (sem hífen).',
            'address.street.required_with'       => 'Preencha o endereço completo ou deixe todos os campos em branco.',
            'address.number.required_with'       => 'Informe o número.',
            'address.neighborhood.required_with' => 'Informe o bairro.',
            'address.city.required_with'         => 'Informe a cidade.',
            'address.state.required_with'        => 'Informe a UF.',
            'address.state.size'                 => 'Informe a UF com 2 letras (ex: SP).',
        ];
    }
}
