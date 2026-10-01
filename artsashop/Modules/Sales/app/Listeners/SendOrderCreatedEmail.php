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

namespace Modules\Sales\Listeners;

use Idea\Framework\Concerns\EmailConfiguration;
use Idea\Framework\Repository\Sales\SalesOrderRepository;
use Illuminate\Support\Facades\Mail;
use Modules\Sales\Emails\SalesOrderCreatedMail;
use Modules\Sales\Events\OrderCreated;


class SendOrderCreatedEmail
{

    use EmailConfiguration;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {

        // Retorna o cliente do E-mail
        $salesOrderCustomer = SalesOrderRepository::getOrderCustomer($event->order->order_id)->first();

        Mail::to($salesOrderCustomer->customer_email)
            ->bcc(
                $this->getEmails()
            )
            ->send(
                new SalesOrderCreatedMail($event->order)
            );
    }

}
