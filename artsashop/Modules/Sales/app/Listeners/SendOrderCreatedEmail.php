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
