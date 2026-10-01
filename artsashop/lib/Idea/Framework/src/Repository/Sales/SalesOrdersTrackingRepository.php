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
declare(strict_types=1);

namespace Idea\Framework\Repository\Sales;

use App\Models\SalesOrdersTracking;
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;

class SalesOrdersTrackingRepository extends AbstractRepository
{

    // Inicializa o Model do Repositório
    protected static $model = SalesOrdersTracking::class;


    public static function saveOrUpdateTracking(int $orderId, array $values)
    {

        // Retorna o tracking
        $orderTracking = self::getOrderTracking($orderId);

        if ($orderTracking->exists()) {

            // Atualiza o Tracking do pedido
            $salesOrderTracking = self::getData()->updateOrCreate(
                attributes: [
                    'tracking_id' => $orderTracking->first()->tracking_id
                ],
                values: $values
            );

        } else {

            // Cria o Tracking do pedido
            $salesOrderTracking = self::getData()->firstOrCreate(
                attributes: $values
            );

        }

        return $salesOrderTracking;

    }


    /**
     * Retorna o tracking do Pedido específico
     * @param $orderId
     * @return Builder
     */
    public static function getOrderTracking($orderId): Builder
    {

        // Inicializa a query
        $query = self::getData();

        // Busca pelo ID do Pedido
        return $query->where("order_id", '=', $orderId);

    }

}
