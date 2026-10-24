<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 *
 * É concedida permissão, gratuitamente, a qualquer pessoa que obtenha uma cópia
 * deste software e arquivos de documentação associados
 *
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
