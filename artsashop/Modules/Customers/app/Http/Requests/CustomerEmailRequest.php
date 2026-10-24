<?php

namespace Modules\Customers\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerEmailRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'customer_email' => ['required', 'email'],
        ];
    }

    /**
     * Mensagens de validação dos campos
     * @return string[]
     */
    public function messages(): array
    {
        return [
            // Email
            'customer_email.required' => 'Informe seu e-mail.',
            'customer_email.email'    => 'Digite um e-mail válido.',
            'customer_email.unique'   => 'Este e-mail já está cadastrado em nosso site.',
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
