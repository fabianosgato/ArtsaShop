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

use App\Models\SalesOrder;
use App\Models\SalesOrderAddress;
use App\Models\SalesOrderCustomer;
use App\Models\SalesOrderItem;
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class SalesOrderRepository extends AbstractRepository
{

    // Inicializa o Model do Repositório
    protected static $model = SalesOrder::class;

    /**
     * Metodo usado para a criação de um pedido
     * @param $attributes
     * @return \App\Models\SalesOrder
     */
    public static function createOrUpdateOrder($attributes): SalesOrder
    {
        return self::getData()->updateOrCreate(
            attributes: [
                'increment_id' => $attributes['increment_id'],
                'store_id' => $attributes['store_id'],
            ],
            values: [
                'store_code' => $attributes['store_code'],
                'status_id' => $attributes['status_id'],
                'status_type' => $attributes['status_type'],
                'status_label' => $attributes['status_label'],
                'status_code' => $attributes['status_code'],
                'payment_method' => $attributes['payment_method'],
                'payment_description' => $attributes['payment_description'],
                'base_discount_amount' => $attributes['base_discount_amount'],
                'base_subtotal' => $attributes['base_subtotal'],
                'base_grand_total' => $attributes['base_grand_total'],
                'canal' => $attributes['canal'],
                'remote_ip' => $attributes['remote_ip'],
                'estimated_delivery_date' => $attributes['estimated_delivery_date'],
                'approved_date' => $attributes['approved_date'],
                'base_shipping_amount' => $attributes['base_shipping_amount'],
            ]
        );
    }

    /**
     * Metodo usado para a criação de um pedido
     * @param $attributes
     * @return \App\Models\SalesOrder
     */
    public static function createOrder($attributes): SalesOrder
    {
        return self::loadModel()::query()->create($attributes);
    }

    /**
     * Metodo usado para a atualização de um pedido
     * @param int $orderId
     * @param array $attributes
     * @return bool
     */
    public static function updateOrder(int $orderId, array $attributes)
    {
        return self::loadModel()::query()
            ->find($orderId)
            ->update($attributes);
    }

    /**
     * Retorna as informações do cliente de um Pedido específico
     * @param $orderId
     * @return Builder
     */
    public static function getOrderCustomer($orderId): Builder
    {
        // Inicializa a query
        $query = SalesOrderCustomer::query();

        $query->addSelect([
            'customer_entity.customer_name',
            'customer_entity.customer_email',
            'customer_entity.date_of_birth',
            'customer_entity.vat_number'
        ]);

        // Join na tabela CustomerEntity
        $query->join(
            table:'customer_entity',
            first:'customer_entity.customer_id',
            operator:'=',
            second:'sales_order_customer.customer_id'
        );

        // Busca pelo ID do Pedido
        $query->where("sales_order_customer.order_id", '=', $orderId);

        return $query;

    }

    /**
     * Retorna os itens do pedido específico
     * @param $orderId
     * @return Builder
     */
    public static function getOrderItens($orderId): Builder
    {

        // Inicializa a query
        $query = SalesOrderItem::query();

        $query->addSelect([
            'sales_order_item.product_sku',
            'sales_order_item.product_name',
            'sales_order_item.qty_ordered',
            'sales_order_item.price as sales_price',
            'catalog_product_prices.price',
            'catalog_product_prices.final_price',
            'catalog_product.product_id',
            'catalog_product.image',
            'catalog_product.slug_key'
        ]);

        // Join na tabela SalesOrder
        $query->join(
            table:'sales_orders',
            first:'sales_orders.order_id',
            operator:'=',
            second:'sales_order_item.order_id'
        );

        // Join na tabela CatalogProduct
        $query->join(
            table:'catalog_product',
            first:'catalog_product.product_id',
            operator:'=',
            second:'sales_order_item.product_id'
        );

        // Join na tabela CatalogProductPrices
        $query->join(
            table:'catalog_product_prices',
            first:'catalog_product_prices.product_id',
            operator:'=',
            second:'catalog_product.product_id'
        );

        // Busca pelo ID do Pedido
        $query->where("sales_orders.order_id", '=', $orderId);

        return $query;
    }

    /**
     * Retorna as informacoes de endereço de um pedido específico
     * @param $orderId
     * @param $addressType
     * @return Builder
     */
    public static function getOrderAddress($orderId, $addressType): Builder
    {

        // Inicializa a query
        $query = SalesOrderAddress::query();

        $query->where(
            column: "order_id",
            operator: '=',
            value: $orderId);

        $query->where(
            column: "address_type",
            operator: '=',
            value: $addressType
        );

        if (!$query->exists() && ($addressType == 'shipping'))
            // Retorna o endereço de cobrança como "shipping"
            $query = self::getOrderAddress($orderId, 'billing');


        return $query;

    }

    /**
     * Retorna as informacoes do pedido pelo ID
     * @param int $orderId
     * @return Builder
     */
    public static function getOrder(int $orderId): Builder
    {

        // Inicializa a query que retorna os dados do pedido
        $query = self::getData();

        // Seleciona o Pedido
        $query->where(
            column: 'sales_orders.order_id',
            operator: '=',
            value: $orderId
        );

        // Retorna as informacoes do pedido
        return $query;

    }

    /**
     * Retorna as informacoes do pedido pelo ID
     * @param string $orderIncrementId
     * @return \App\Models\SalesOrder|null
     */
    public static function getOrderByIncrementId(string $orderIncrementId): ?SalesOrder
    {

        // Inicializa a query que retorna os dados do pedido
        $salesOrder = self::getData();

        // Seleciona o Pedido
        $salesOrder->where(
            column: 'sales_orders.increment_id',
            operator: '=',
            value: $orderIncrementId
        );

        // Retorna as informacoes do pedido de existir
        if ($salesOrder->exists())
            return $salesOrder->first();

        // Retorna null caso nao exista
        return null;

    }

    /**
     * Retorna as informações de um pedido pelo icrementId
     * @param string $incrementCode
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getByIncrement(string $incrementCode): Builder
    {

        // Inicializa a query que retorna os dados do pedido
        $query = self::getData();

        // Seleciona o Pedido
        $query->where(
            column: 'sales_order_code.increment_code',
            operator: '=',
            value: $incrementCode
        );

        // Retorna as informacoes do pedido
        return $query;

    }

    /**
     * Retorna os pedidos pelo ID do cliente
     * @param $customerId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getOrdersByCustomerId($customerId, int $limit = 0): Builder
    {

        // Inicializa a query que retorna os dados do pedido
        $query = self::getData();

        // Seleciona o(s) Pedido(s) pelo ID do Cliente
        $query->where(
            column: 'sales_order_customer.customer_id',
            operator: '=',
            value: $customerId
        );

        // Ordena os pedidos do cliente por ordem decrescente
        $query->orderBy('order_id', 'desc');

        // Valida se possui limite
        if ($limit > 0)
            $query->limit($limit);

        // Retorna as informacoes do pedido
        return $query;

    }

    /**
     * Retorna as informacoes do pedido Aprovado pelo Id
     * @param int $orderId
     * @return Builder
     */
    public static function getApprovedOrder(int $orderId): Builder
    {

        // Inicializa a query que retorna os dados do pedido
        $query = self::getData();

        // Filtra pelo ID do pedido
        $query->where(
            column: 'sales_orders.order_id',
            operator: '=',
            value: $orderId
        );

        // Retorna as informacoes do pedido
        return $query;

    }

    /**
     * Retorna os pedidos por data
     * @param $dateIni
     * @param $dateEnd
     * @return Builder
     */
    public static function getApprovedByDate($dateIni, $dateEnd): Builder
    {

        // Inicializa a query de Pedidos
        $query = self::loadModel()::query();

        // Query na Tabela de status de pedidos
        $query->join(
            table:'sales_order_status',
            first:'sales_order_status.status_id',
            operator: '=',
            second: 'sales_orders.status_id'
        );

        // Seleciona apenas os status de pedidos que sao "enviados"
        $query->where('sales_order_status.status', '=', 'shipped');

        $query->whereBetween(
            'created_at', [
                $dateIni,
                $dateEnd
            ]
        );

        return $query;

    }

    /**
     * Retorna apenas os pedidos Aprovados
     * @return Builder
     */
    public static function getOrdersPagination($perPage): LengthAwarePaginator
    {

        // Inicializa a query que retorna os dados do pedido
        $query = self::getData();

        $query->orderBy(
            column: 'sales_orders.created_at',
            direction: 'desc'
        );

        // Retora os pedidos paginados
        return $query->paginate($perPage);

    }

    /**
     * Retorna todos os pedidos NAO aprovados
     * @return Builder
     */
    public static function getReportOrder(): Builder
    {

        // Inicializa a query que retorna os dados do pedido
        $query = self::getData();

        $query->where(
            column: 'sales_order_status.is_enabled',
            operator: '=',
            value: 0
        );

        return $query;

    }

    /**
     * Metodo que retorna todos os pedidos do sistema
     * @return Builder
     */
    public static function getData(): Builder
    {
        // Certifique-se de incluir o facade DB no topo do arquivo: use Illuminate\Support\Facades\DB;
        return self::loadModel()::query()
            ->select([
                'sales_orders.order_id',
                'sales_orders.store_id',
                'sales_orders.increment_id',
                'sales_orders.store_code',
                'sales_orders.status_type',
                'sales_orders.status_label',
                'sales_orders.status_code',
                'sales_orders.payment_method',
                'sales_orders.payment_description',
                'sales_orders.base_shipping_amount',
                'sales_orders.base_discount_amount',
                'sales_orders.base_subtotal',
                'sales_orders.base_grand_total',
                'sales_orders.canal',
                'sales_orders.remote_ip',
                'sales_orders.estimated_delivery_date',
                'sales_orders.approved_date',
                'sales_orders.delivered_date',
                'sales_orders.created_at',
                'sales_orders.updated_at',

                'sales_order_code.increment_code',


                'sales_order_status.status',
                'sales_order_status.label',

                'sales_order_customer.customer_id',
                'customer_entity.customer_name',
                'customer_entity.customer_email',
                'customer_entity.vat_number AS customer_document',
                'customer_entity.date_of_birth AS customer_date_of_birth',

                'sales_order_payments.value as payment_amount',
                'sales_order_payments.method',
                'sales_order_payments.description',

            ])

            // Join na tabela de Status de Pedidos
            ->join(
                table:'sales_order_code',
                first:'sales_order_code.order_id',
                operator: '=',
                second: 'sales_orders.order_id'
            )
            // Join na tabela de Status de Pedidos
            ->join(
                table:'sales_order_status',
                first:'sales_order_status.status_id',
                operator: '=',
                second: 'sales_orders.status_id'
            )

            // Join na tabela de Clientes
            ->join(
                table:'sales_order_customer',
                first:'sales_order_customer.order_id',
                operator: '=',
                second: 'sales_orders.order_id'
            )

            // Join na tabela de Clientes
            ->join(
                table:'customer_entity',
                first:'customer_entity.customer_id',
                operator:'=',
                second:'sales_order_customer.customer_id'
            )

            // Join na tabela de Pagamentos
            ->join(
                table:'sales_order_payments',
                first:'sales_order_payments.order_id',
                operator:'=',
                second:'sales_orders.order_id'
            )

            // Agrupa por todas as colunas não agregadas (compatível com ONLY_FULL_GROUP_BY)
            ->groupBy([
                'sales_orders.order_id'
            ]);

    }

}
