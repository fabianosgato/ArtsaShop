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
namespace Modules\Checkout\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CheckoutAddressesRegisterRequest extends FormRequest
{

    /**
     * Cria as validações do checkout
     * @return string[]
     */
    public function rules(): array
    {

        // Inicializa os dados de Validação
        $validationData = [];

        // Valida se o cliente está logado
        if (Auth::guard('customer')->check()) {

            if ($this->input('address_option') !== 'saved') {

                $validationData['billing.cellphone'] = 'required|string';
                $validationData['billing.postcode'] = 'required|string';
                $validationData['billing.region'] = 'required|string';
                $validationData['billing.street'] = 'required|string';
                $validationData['billing.number'] = 'required|string';
                $validationData['billing.city'] = 'required|string';
                $validationData['billing.neighborhood'] = 'required|string';

            }

            return $validationData;

        } else {

            $validationData['billing.cellphone'] = 'required|string';
            $validationData['billing.postcode'] = 'required|string';
            $validationData['billing.region'] = 'required|string';
            $validationData['billing.street'] = 'required|string';
            $validationData['billing.number'] = 'required|string';
            $validationData['billing.city'] = 'required|string';
            $validationData['billing.neighborhood'] = 'required|string';

        }

        // Valida se o Cliente irá entregar em outro endereço
        if ($this->input('billing.use_different_shipping')) {

            $validationData['shipping.postcode'] = 'required|string';
            $validationData['shipping.region'] = 'required|string';
            $validationData['shipping.street'] = 'required|string';
            $validationData['shipping.number'] = 'required|string';
            $validationData['shipping.city'] = 'required|string';
            $validationData['shipping.neighborhood'] = 'required|string';

        }

        // Retorna os dados de Validação
        return $validationData;

    }

    public function messages(): array
    {
        return [

            // Mensagens do Cadastro do cliente
            'register.customer_name' => 'Informe o seu nome Completo',
            'register.email_address' => 'Informe seu e-mail corretamente',
            'register.vat_number' => 'Informe seu CPF/CNPJ corretamente',

            'register.password.required' => 'Sua senha é obrigatória',
            'register.password.confirmed' => 'As senhas não conferem',
            'register.password.min' => 'A senha deve ter pelo menos :min caracteres',

            'register.password.letters' => 'A senha deve conter pelo menos uma letra',
            'register.password.numbers' => 'A senha deve conter pelo menos um número',

            // Mensagem de e-mail unico
            'register.email_address.unique' => 'Este e-mail já está cadastrado em nosso site.',

            // Mensagem de validação do billing
            'billing.cellphone' => 'Informe um telefone celular válido para contato.',
            'billing.postcode' => 'Informe o CEP do endereço.',
            'billing.region' => 'Selecione o estado.',
            'billing.street' => 'Informe o endereço.',
            'billing.number' => 'Informe o seu número residencial.',
            'billing.city' => 'Informe a cidade.',
            'billing.neighborhood' => 'Informe o bairro.',

            // Mensagens de validação do Shipping
            'shipping.postcode' => 'Informe o CEP do endereço de Entrega.',
            'shipping.region' => 'Selecione o estado do endereço de Entrega.',
            'shipping.street' => 'Informe o endereço de Entrega',
            'shipping.number' => 'Informe o seu número residencial do endereço de Entrega.',
            'shipping.city' => 'Informe a cidade do endereço de Entrega.',
            'shipping.neighborhood' => 'Informe o bairro do endereço de Entrega.',

            // Mensagem de validação do pagamento
            'paymentMethod.required' => 'Selecione uma forma de pagamento para continuar.',

        ];
    }

    public function attributes(): array
    {
        return [
            'billing.name' => 'Nome Completo',
            'billing.postcode' => 'CEP',
            'billing.cellphone' => 'Celular',
            'billing.region' => 'estado',
            'billing.street' => 'Endereço',
            'billing.number' => 'Número',
            'billing.city' => 'cidade',
            'billing.neighborhood' => 'bairro',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }


}
