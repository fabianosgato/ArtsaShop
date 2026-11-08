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
namespace Modules\Payments\Gateways\Ipag\Concerns;

use Modules\Payments\Gateways\Ipag\Core\Enums\Cards;
use Modules\Payments\Gateways\Ipag\Core\Enums\PaymentTypes;

trait CreditCard
{

    private function getBrand($cardBrand): ?string
    {

        if ($cardBrand == 'visa') {
            return Cards::VISA;
        } else if ($cardBrand == 'mastercard') {
            return Cards::MASTERCARD;
        } else if ($cardBrand == 'elo') {
            return Cards::ELO;
        } else if ($cardBrand == 'amx') {
            return Cards::AMEX;
        } else if ($cardBrand == 'discover') {
            return Cards::DISCOVER;
        } else if ($cardBrand == 'hipercard') {
            return Cards::HIPERCARD;
        }

        return null;

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
