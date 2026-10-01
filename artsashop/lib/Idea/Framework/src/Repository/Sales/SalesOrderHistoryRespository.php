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

namespace Idea\Framework\Repository\Sales;

use App\Models\SalesOrder;
use App\Models\SalesOrderHistory;
use Idea\Framework\Repository\AbstractRepository;

class SalesOrderHistoryRespository extends AbstractRepository
{

    protected static $model = SalesOrderHistory::class;

    /**
     * Cria o historico do pedido
     * @param \App\Models\SalesOrder $salesOrder
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function createHistory(SalesOrder $salesOrder, array $attributes)
    {

        return self::getData()->updateOrCreate(
            attributes: [
                'order_id' => $salesOrder->order_id
            ],
            values: [
                'order_id' => $salesOrder->order_id,
                'is_customer_notified' => $attributes['is_customer_notified'],
                'is_visible_on_front' => $attributes['is_visible_on_front'],
                'comment' => $attributes['comment'],
                'status_code' => $attributes['status_code']
            ]);

    }

}
