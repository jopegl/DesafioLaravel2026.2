<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('address'));
    }

    public function rules(): array
    {
        return [
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
}
