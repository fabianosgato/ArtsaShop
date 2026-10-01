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
namespace Modules\Checkout\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AddressValidator
{
    /**
     * Valida os endereços do cliente
     * @param array $quote
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function validate(array $quote): void
    {

        // Billing é sempre obrigatório
        if (!isset($quote['billing'])) {
            throw ValidationException::withMessages([
                'billing' => 'Endereço de cobrança é obrigatório.',
            ]);
        }

        self::validateAddress($quote['billing'], 'billing');

        // Shipping só é obrigatório se existir
        if (isset($quote['billing']['use_different_shipping'])) {
            self::validateAddress($quote['shipping'], 'shipping');
        }

    }

    private static function validateAddress(array $address, string $scope): void
    {

        $validator = Validator::make($address, [
            'postcode' => 'required|string|min:8',
            'street' => 'required|string|min:3',
            'neighborhood' => 'required|string|min:2',
            'city' => 'required|string|min:2',
            'region' => 'required|string|min:2',
        ], [
            'required' => 'O campo :attribute é obrigatório e deve ser preechido.',
        ], [
            'name' => 'nome',
            'postcode' => 'CEP',
            'street' => 'endereço',
            'neighborhood' => 'bairro',
            'city' => 'cidade',
            'region' => 'estado',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages([
                $scope => $validator->errors()->toArray(),
            ]);
        }
    }
}
