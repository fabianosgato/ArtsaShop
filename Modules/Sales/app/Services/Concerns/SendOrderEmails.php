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
