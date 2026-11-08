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
declare(strict_types=1);

namespace Idea\Framework\Repository\Sales;

use App\Models\SalesOrderPayment;
use Idea\Framework\Repository\AbstractRepository;

class SalesOrderPaymentRepository extends AbstractRepository
{

    protected static $model = SalesOrderPayment::class;

    /**
     * Salva as informações do pagamento do pedido
     * @param $attributes
     * @return \App\Models\SalesOrderPayment
     */
    public static function createPayment($attributes): SalesOrderPayment
    {

        return self::getData()->updateOrCreate(
            attributes: [
                'order_id' => $attributes['order_id']
            ],
            values: [
                'order_id' => $attributes['order_id'],
                'method' => $attributes['method'],
                'value' => $attributes['value'],
                'description' => $attributes['description'],
                'additional_information' => $attributes['additional_information']
            ]
        );

    }

    public static function getPaymentByOrderId($orderId): ?array
    {

        $payment = self::getData()->where(
            column: 'order_id',
            operator: '=',
            value: $orderId
        );

        if ($payment->exists())
            return [
                'method' => $payment->first()->method,
                'description' => $payment->first()->description,
                'value' => $payment->first()->value,
                'additional_information' => json_decode($payment->first()->additional_information, true),
            ];

        return null;
    }

}
