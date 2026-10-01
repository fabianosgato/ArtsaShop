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

class CheckoutPlaceOrderRequest extends FormRequest
{

    /**
     * Cria as validações do checkout
     * @return string[]
     */
    public function rules(): array
    {

        // Valida o pagamento
        $validationData['paymentMethod'] = 'required|string';

        // Valida o CPF/CNPJ
        $validationData['register.vat_number'] = 'required|cpf_ou_cnpj';

        // Retorna os dados de Validação
        return $validationData;

    }

    public function messages(): array
    {
        return [
            // Mensagem de CPF/CNPJ invalido
            'register.vat_number' => 'Informe seu CPF/CNPJ corretamente',

            // Mensagem de validação do pagamento
            'paymentMethod.required' => 'Selecione uma forma de pagamento para continuar.',

        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
