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
use Modules\Payments\Gateways\Pagarme\Concerns\CustomerPayload;
use Modules\Payments\Gateways\Pagarme\Concerns\ItensPayload;
use Modules\Payments\Gateways\Pagarme\Order\PagarmeOrder;

class PagarmePix
{

    use CustomerPayload, ItensPayload;

    public function __construct(
        protected PagarmeOrder $order
    ) {
    }

    public function create(SalesOrder $salesOrder): array
    {

        $payload = [
            'closed' => true,
            'customer' => $this->createCustomerPayload($salesOrder->order_id),
            'items' => $this->createPayloadOrderItens($salesOrder),

            'payments' => [
                [
                    'payment_method' => 'pix',
                    'pix' => [
                        'expires_in' => '1800',
                        'additional_information' => [
                            [
                                'name' => 'information',
                                'value' => 'number',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $this->order->create(
            payload: $payload
        );

    }

}
