<?php

namespace Modules\Checkout\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CheckoutCustomerRegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {

        // Validação do nome do Cliente
        $validationData['register.customer_name'] = [
            'required',
            'string',
            'min:5',
            'max:255',
            'regex:/^.+\s+.+$/'
        ];

        // Validação do e-mail do cliente
        $validationData['register.email_address'] = [
            'required',
            'email',
        ];

        // Verifica se o cliente está criando a conta
        if (!empty($this->input('register.customer_create_account'))) {

            // Validação do e-mail do cliente
            $validationData['register.password'] = [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->numbers()
            ];

        }

        return $validationData;

    }

    /**
     * Retorna as mensagens de validação
     * @return string[]
     */
    public function messages() :array
    {

        return [
            // Mensagens do Cadastro do cliente
            'register.customer_name' => 'Informe o seu nome Completo',
            'register.email_address' => 'Informe seu e-mail corretamente',

            // Validações de senha
            'register.password.required'      => 'Informe uma senha.',
            'register.password.confirmed'     => 'As senhas não conferem.',
            'register.password.min'           => 'A senha deve ter pelo menos 8 caracteres.',
            'register.password.letters'       => 'A senha deve conter pelo menos uma letra.',
            'register.password.numbers'       => 'A senha deve conter pelo menos um número.',

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
