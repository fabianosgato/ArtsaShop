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

namespace Modules\Payments\Concerns;

use Modules\Payments\Enums\Cards;
use Modules\Payments\Enums\PaymentTypes;

trait CreditCard
{

    private function getBrand($cardBrand): ?Cards
    {
        return match ($cardBrand) {
            'amx' => Cards::AMEX,
            default => Cards::tryFrom($cardBrand),
        };
    }

    /**
     * Monta o array para o pagamento do cartão de crédito
     * @param $paymentCard
     * @return array
     */
    public function paymentDataCreditCard($paymentCard): array
    {

        list($expiryMonth, $expiryYear) = explode('/', $paymentCard['card_expiry']);

        return [
            'type' => PaymentTypes::CARD,
            'method' => $this->getBrand($paymentCard['card_brand']),
            'installments' => $paymentCard['card_installments'],
            'softdescriptor' => 'Examix.com.br',
            'capture' => true,
            'fraud_analysis' => true,
            'card' => [
                'holder' => $paymentCard['card_holder'],
                'number' => $paymentCard['card_number'],
                'expiry_month' => $expiryMonth,
                'expiry_year' => $expiryYear,
                'cvv' => $paymentCard['card_cvv'],
            ],
//            'authenticationPolicy' => [
//                'threeDSecure' => [
//                    'mode' => 'disabled'
//                ]
//            ]
        ];

    }

}
