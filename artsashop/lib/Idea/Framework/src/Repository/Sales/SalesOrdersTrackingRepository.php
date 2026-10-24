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
