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
namespace Modules\Sales\Services\Concerns;

use Modules\Sales\Events\OrderCreated;

trait SendOrderEmails
{

    /**
     * Cria o envio de mail na Criação do pedido
     * @param $salesOrder
     * @return void
     */
    public function sendCreatedOrderMail($salesOrder)
    {
        event(new OrderCreated($salesOrder));
    }

}
