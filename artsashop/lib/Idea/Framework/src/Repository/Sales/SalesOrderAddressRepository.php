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

use App\Models\SalesOrderAddress;
use Idea\Framework\Repository\AbstractRepository;

class SalesOrderAddressRepository extends AbstractRepository
{

    protected static $model = SalesOrderAddress::class;

    /**
     * Retorna os endereços do cliente
     * @param $orderId
     * @param $addressType
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function getAddress($orderId, $addressType)
    {

        // Inicializa a query que retorna os dados do pedido
        $query = self::loadModel()::query();

        // Busca pelo ID do pedido
        $query->where(
            column: 'order_id',
            operator: '=',
            value: $orderId
        );

        // Busca pelo Tipo do endereço
        $query->where(
            column: 'address_type',
            operator: '=',
            value: $addressType
        );

        if ($query->exists())
            return $query->get()->first();

        return null;

    }

    /**
     * Cria os endereços do pedido na base de dados
     * @param int $orderId
     * @param int $customerId
     * @param array $attributes
     * @return \App\Models\SalesOrderAddress|null
     */
    public static function createOrderAddress(int $orderId, int $customerId, array $attributes): ?SalesOrderAddress
    {

        return self::getData()->create(
            attributes: [
                'order_id' => $orderId,
                'customer_id' => $customerId,
                'address_type' => $attributes['address_type'],
                'customer_name' => $attributes['customer_name'],
                'customer_cellphone' => $attributes['customer_cellphone'],
                'customer_phone' => $attributes['customer_phone'] ?? '',
                'postcode' => $attributes['postcode'],
                'street' => $attributes['street'],
                'complement' => $attributes['complement'] ?? null,
                'number' => $attributes['number'],
                'neighborhood' => $attributes['neighborhood'],
                'city' => $attributes['city'],
                'region' => $attributes['region'],
                'country' => 'Brasil',
            ]
        );

    }

}
