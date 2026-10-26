<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactsRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {

        return [
            'contact_name' => 'required|string|max:255',
            'email_address' => ['required', 'email'],
            'phone_contacts' => ['required'],
            'subject_contacts' => ['required'],
            'message_contacts' => ['required'],
        ];

    }

    public function messages(): array
    {
        return [
            'contact_name' => 'Seu Nome Completo é obrigatório.',
            'email_address' => 'Seu E-mail é obrigatório.',
            'phone_contacts' => 'Seu Telefone é obrigatório.',
            'subject_contacts' => 'O Assunto é um Campo Obrigatório.',
            'message_contacts' => 'A mensagem é um Campo Obrigatório.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

}
