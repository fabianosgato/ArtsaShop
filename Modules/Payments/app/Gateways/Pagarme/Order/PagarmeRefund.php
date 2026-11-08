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
 ****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */
declare(strict_types=1);

namespace Modules\Payments\Gateways\Pagarme\Order;

use Modules\Payments\Gateways\Pagarme\Core\PagarmeClient;

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
