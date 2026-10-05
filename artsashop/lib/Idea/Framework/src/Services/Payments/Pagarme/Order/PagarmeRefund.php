<?php
/**
 * Fabiano Gatto
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
 * @copyright    Copyright (c) Fabiano Gatto
 * @author       Fabiano Gatto <fabianogattoti@gmail.com>
 *
 */

declare(strict_types=1);

namespace Idea\Framework\Services\Payments\Pagarme\Order;

use Idea\Framework\Services\Payments\Pagarme\Core\PagarmeClient;

class PagarmeRefund
{

    public function __construct(
        protected PagarmeClient $client
    ) {
    }

    /**
     * Solicita o estorno do pagamento no Pagar.me.
     *
     * @param array $paymentInformation
     * @return array
     */
    public function create(
        array $paymentInformation
    ): array
    {

        $response = $this->client->delete(
            uri: "/charges/{$paymentInformation['charge_id']}",
            data: [
                'amount' => $paymentInformation['paid_amount'],
            ]
        );

        return $response->json();

    }

}
