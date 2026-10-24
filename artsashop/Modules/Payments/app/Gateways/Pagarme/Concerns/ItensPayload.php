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
namespace Modules\Payments\Gateways\Pagarme\Concerns;

use App\Models\SalesOrder;
use Carbon\Carbon;
use Idea\Framework\Repository\Sales\SalesOrderRepository;

trait ItensPayload
{

    private function formatClinicsShedule(
        ?string $date,
        ?string $time
    ): string {

        if (blank($date) || blank($time)) {
            return '-';
        }

        $appointment = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            "{$date} {$time}"
        );

        return $appointment->format('d/m \à\s H:i');

    }


    /**
     * Retorna os itens do pedido
     * @param $orderId
     * @return array
     */
    private function createPayloadOrderItens(SalesOrder $salesOrder): array
    {

        $itens = [];

        $salesOrderItens = SalesOrderRepository::getOrderItens(
            $salesOrder->order_id
        )->get();

        if ($salesOrderItens) {

            foreach ($salesOrderItens as $salesOrderItem) {

                $itens[] = [
                    'id' => sprintf(
                        '%s_%s',
                        $salesOrder->increment_code, $salesOrderItem->product_sku,
                    ),
                    'amount' => intval(preg_replace(
                        '/\D/',
                        '',
                        number_format($salesOrderItem->final_price, 2),
                    )),
                    'description' => sprintf(
                        '%s, %s',
                        $salesOrderItem->custom_name,
                        $this->formatClinicsShedule(
                            $salesOrderItem->date,
                            $salesOrderItem->start_time
                        )
                    ),
                    'quantity' => intval($salesOrderItem->qty_ordered),
                    'code' => $salesOrderItem->product_sku,
                    'status' => 'active'
                ];

            }

        }

        return $itens;

    }

}
