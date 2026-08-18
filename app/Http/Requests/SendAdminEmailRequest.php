<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendAdminEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'O usuário destinatário é obrigatório.',
            'user_id.exists'   => 'O usuário selecionado não existe.',

            'subject.required' => 'O assunto é obrigatório.',
            'subject.string'   => 'O assunto deve ser um texto.',
            'subject.max'      => 'O assunto não pode ter mais de 255 caracteres.',

            'message.required' => 'A mensagem é obrigatória.',
            'message.string'   => 'A mensagem deve ser um texto.',
        ];
    }
}
