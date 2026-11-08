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
namespace Modules\Payments\Gateways\Pagarme\Types;

use App\Models\SalesOrder;
use Idea\Framework\Apis\Api;
use Modules\Payments\Gateways\Pagarme\Concerns\CustomerPayload;
use Modules\Payments\Gateways\Pagarme\Concerns\ItensPayload;
use Modules\Payments\Gateways\Pagarme\Order\PagarmeOrder;

class PagarmeCreditCard
{

    use CustomerPayload, ItensPayload;

    public function __construct(
        protected PagarmeOrder $order
    ) {
    }

    public static function getCreditCardToken(array $cardData): array
    {

        return Api::sendRequest(
            url: 'https://api.pagar.me/core/v5/tokens?appId='.getPagarmePublicKey(),
            payload: [
                'type' => 'card',
                'card' => $cardData
            ]
        );

    }

    public function create(
        SalesOrder $salesOrder,
        string $cardToken,
        string $holderName,
        int $installments = 1
    ): array
    {

        // Retorna os dados do cliente
        $customer = $this->createCustomerPayload($salesOrder->order_id);

        $payload = [
            'closed' => true,
            'code' => $salesOrder->increment_code,
            'customer' => $customer,
            'items' => $this->createPayloadOrderItens($salesOrder),
            'payments' => [
                [
                    'payment_method' => 'credit_card',
                    'credit_card' => [
                        'operation_type' => 'auth_and_capture',
                        'installments' => $installments,
                        'statement_descriptor' => 'EXAMIX',
                        'card_token' => $cardToken,
                        'card' => [
                            'holder_name' => $holderName,
                            'billing_address' => $customer['address'],
                        ]
                    ],
                ],
            ],
        ];

        return $this->order->create(
            payload: $payload
        );

    }

}
