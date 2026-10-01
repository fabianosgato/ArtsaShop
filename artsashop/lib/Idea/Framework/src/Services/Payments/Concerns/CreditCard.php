<?php

namespace Idea\Framework\Services\Payments\Concerns;

use Idea\Framework\Services\Payments\Ipag\Core\Enums\Cards;
use Idea\Framework\Services\Payments\Ipag\Core\Enums\PaymentTypes;

trait CreditCard
{

    private function getBrand($cardBrand)
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
     * Monta o array para o pagamento do cartão de credito
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
            'softdescriptor' => config('app.name'),
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
