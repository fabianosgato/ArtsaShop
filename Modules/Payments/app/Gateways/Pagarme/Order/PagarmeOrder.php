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
namespace Modules\Payments\Gateways\Pagarme\Order;

use Modules\Payments\Gateways\Pagarme\Core\PagarmeClient;

class PagarmeOrder
{
    public function __construct(
        protected PagarmeClient $client
    ) {
    }

    /**
     * Cria um pedido na API Pagar.me.
     */
    public function create(array $payload): array
    {

        return $this->client
            ->post(
                uri: '/orders',
                data: $payload
            )
            ->json();
    }

}
