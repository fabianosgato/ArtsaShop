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
namespace Modules\Sales\Transformers;

use Idea\Framework\Repository\Sales\SalesOrderRepository;
use Idea\Framework\Repository\Sales\SalesOrdersTrackingRepository;
use Idea\Framework\Repository\System\SysAddressStateRepository;
use Idea\Framework\Repository\System\SysStoreRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesOrderResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {

        $orderData = [
            'orderId' => $this->order_id,
            'incrementCode' => $this->increment_code,
            'stores' => $this->getStoreOrder($this->store_id),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'approvedAt' => $this->updated_at,
            'estimatedDeliveryShift' => $this->updated_at,
            'status' => [
                'label' => $this->label,
                'code' => $this->status,
                'type' => $this->status_type
            ],
            'customer' => [
                'customerName' => $this->customer_name,
                'customerEmail' => $this->customer_email,
                'customerDocument' => $this->customer_document,
                'customerDateOfBirth' => $this->customer_date_of_birth,
            ],
            'billing' => $this->getAddress(
                orderId: $this->order_id,
                addressType:'billing'
            ),
            'shipping' =>  $this->getAddress(
                orderId: $this->order_id,
                addressType:'shipping'
            ),
            'payments' => [
                'method' => $this->payment_method,
                'description' => $this->payment_description,
                'amount' => floatval($this->payment_amount),
            ],
            'itens' => $this->getOrderItens(
                orderId: $this->order_id,
            ),
            'totals' => [
                'shipping_total' => floatval($this->base_shipping_amount),
                'discount_total' => floatval($this->base_discount_amount),
                'subtotal' => floatval($this->base_subtotal),
                'grand_total' => floatval($this->base_grand_total),
            ]
        ];

        // Valida se o pedido possui tracking
        $tracking = $this->getTracking($this->order_id);

        if ($tracking)
            // Adiciona ao array o tracking do pedido
            $orderData['tracking'] = $tracking;

        return $orderData;

    }


    public function getStoreOrder($storeId)
    {

        $store = SysStoreRepository::getStoreById($storeId);

        return [
            'store' => $store->store_name,
            'host' => $store->host,
        ];

    }

    /**
     * Retorna os itens do pedido
     * @param int $orderId
     * @return array
     */
    public function getOrderItens(int $orderId): array
    {

        $item = [];

        $salesOrderItens = SalesOrderRepository::getOrderItens($orderId)
            ->get()
            ->toArray();

        foreach ($salesOrderItens as $salesOrderItem) {
            $item[] = [
                'productSku' => $salesOrderItem['product_sku'],
                'productName' => $salesOrderItem['product_name'],
                'qtyOrdered' => intval($salesOrderItem['qty_ordered']),
                'salesPrice' => floatval($salesOrderItem['sales_price']),
                'productPrice' => floatval($salesOrderItem['price']),
                'productPromotionalPrice' => floatval($salesOrderItem['final_price']),
                'shippingCost' => 0
            ];
        }

        return $item;

    }

    /**
     * Retorna o endereço do pedido pelo tipo: billing ou shipping
     * @param int $orderId
     * @param string $addressType
     * @return array
     */
    public function getAddress(int $orderId, string $addressType): array
    {

        // Retorna o endereço do pedido pelo tipo
        $salesOrderAddress = SalesOrderRepository::getOrderAddress($orderId, $addressType);

        if (!$salesOrderAddress->exists()) {
            // Retorna o endereço de cobrança
            $salesOrderAddress = SalesOrderRepository::getOrderAddress($orderId, 'billing');
        }

        if ($salesOrderAddress->exists()) {

            $salesOrderAddressData = $salesOrderAddress->first()->toArray();

            return [
                'customerName' => $salesOrderAddressData['customer_name'],
                'customerPhone' => $salesOrderAddressData['customer_phone'],
                'customerCellPhone' => $salesOrderAddressData['customer_cellphone'],
                'postcode' => $salesOrderAddressData['postcode'],
                'street' => $salesOrderAddressData['street'],
                'number' => $salesOrderAddressData['number'],
                'complement' => $salesOrderAddressData['complement'],
                'neighborhood' => $salesOrderAddressData['neighborhood'],
                'region' => $salesOrderAddressData['region'],
                'state' => SysAddressStateRepository::getStateByUf($salesOrderAddressData['region']),
                'detail' => $salesOrderAddressData['detail'],
                'reference' => $salesOrderAddressData['reference'],
                'city' => $salesOrderAddressData['city'],
                'country' => $salesOrderAddressData['country'],
            ];

        } else {
            return [];

        }

    }

    /**
     * Retorna o tracking do pedido
     * @param $orderId
     * @return array|null
     */
    public function getTracking($orderId)
    {

        $salesOrderTracking = SalesOrdersTrackingRepository::getOrderTracking($orderId);

        if ($salesOrderTracking->exists()) {

            $tracking = $salesOrderTracking->first()->toArray();

            return [
                'trackingCode' => $tracking['tracking_code'],
                'carrier' => $tracking['carrier'],
                'method' => $tracking['method'],
                'url' => $tracking['url'],
            ];

        }

        return null;

    }

}
