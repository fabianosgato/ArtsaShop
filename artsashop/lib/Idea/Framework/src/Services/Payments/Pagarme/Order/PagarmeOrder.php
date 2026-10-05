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
namespace Idea\Framework\Services\Payments\Pagarme\Order;

use Idea\Framework\Services\Payments\Pagarme\Core\PagarmeClient;

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
