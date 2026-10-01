<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * Não editar ou acrescentar à este arquivo se você quiser fazer o upgrade para versões
 * mais recentes no futuro.
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */
namespace Modules\Customers\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterCustomerRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {

        return [
            'customer_name' => [
                'required',
                'string',
                'min:5',
                'max:255',
                'regex:/^.+\s+.+$/'
            ],
            'vat_number' => 'required|cpf_ou_cnpj',
            'customer_email' => ['required', 'email', Rule::unique('customer_entity', 'customer_email')],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->numbers()
            ],
        ];

    }

    /**
     * Mensagens de validação dos campos
     * @return string[]
     */
    public function messages(): array
    {
        return [
            // Nome
            'customer_name.required' => 'Informe seu nome completo.',
            'customer_name.string'   => 'O nome deve conter apenas texto válido.',
            'customer_name.min'      => 'O nome não pode ter menos que 5 caracteres.',
            'customer_name.max'      => 'O nome não pode ultrapassar 255 caracteres.',
            'customer_name.regex' => 'Informe seu nome completo (nome e sobrenome).',

            // CPF/CNPJ
            'vat_number.required'    => 'Informe seu CPF ou CNPJ.',
            'vat_number.cpf_ou_cnpj' => 'CPF ou CNPJ inválido. Verifique os dados informados.',

            // Email
            'customer_email.required' => 'Informe seu e-mail.',
            'customer_email.email'    => 'Digite um e-mail válido.',
            'customer_email.unique'   => 'Este e-mail já está cadastrado em nosso site.',

            // Senha
            'password.required'      => 'Informe uma senha.',
            'password.confirmed'     => 'As senhas não conferem.',
            'password.min'           => 'A senha deve ter pelo menos 8 caracteres.',
            'password.letters'       => 'A senha deve conter pelo menos uma letra.',
            'password.numbers'       => 'A senha deve conter pelo menos um número.',
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
