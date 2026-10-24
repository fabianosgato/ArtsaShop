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
namespace Modules\Sales\Emails;

use App\Models\SalesOrder;
use Idea\Framework\Repository\System\SysStoreRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Sales\Emails\Concerns\Configuration;
use Modules\Sales\Transformers\SalesOrderResource;

class SalesOrderCreatedMail extends Mailable
{
    use Queueable, SerializesModels, Configuration;

    public SalesOrder $order;

    /**
     * Create a new message instance.
     */
    public function __construct(SalesOrder $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {

        // Retorna todos os dados do pedido
        $orderData = (new SalesOrderResource($this->order))->resolve();

        // Retorna a store do pedido
        $store = SysStoreRepository::getStoreByCodeOrder(
            codeOrder: substr($orderData['incrementCode'], 0, strpos($orderData['incrementCode'], '-'))
        );

        return $this->subject("{$store->store_name} :: Pedido #{$orderData['incrementCode']} Realizado no site")
            ->bcc($this->getEmails())
            ->view('sales::frontend.emails.order-created', [
                'store' => $store,
                'orderData' => $orderData
            ]);

    }
}
