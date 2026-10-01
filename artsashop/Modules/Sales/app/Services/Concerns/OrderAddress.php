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

namespace Modules\Sales\Services\Concerns;

use App\Models\CustomerEntity;
use App\Models\SalesOrder;
use App\Models\SalesOrderAddress;
use App\Models\SalesOrderQuote;
use Idea\Framework\Repository\Customer\CustomerAddressRepository;
use Idea\Framework\Repository\Sales\SalesOrderAddressRepository;
use Idea\Framework\Repository\Sales\SalesOrderQuoteAddressRepository;

trait OrderAddress
{

    /**
     * Persiste os endereços do cliente no pedido
     * @param \App\Models\SalesOrder $order
     * @param \App\Models\CustomerEntity $customer
     * @param \App\Models\SalesOrderQuote $quote
     * @return void
     */
    private function persistOrderAddresses(
        SalesOrder      $order,
        CustomerEntity  $customer,
        SalesOrderQuote $quote
    ): void
    {

        // Retorna os endereços do Quote
        $addresses = SalesOrderQuoteAddressRepository::getQuoteAddressByQuote($quote->quote_id);

        // Lista os endereços do Quote
        foreach ($addresses as $address) {

            // Cria o endereço do cliente no Pedido
            $salesOrderAddress = SalesOrderAddressRepository::createOrderAddress(
                orderId: $order->order_id,
                customerId: $customer->customer_id,
                attributes: [
                    'order_id' => $order->order_id,
                    'customer_id' => $customer->customer_id,
                    'customer_name' => $address['recipient_name'] ?? $customer->customer_name,
                    'customer_cellphone' => $address['cellphone'] ?? '',
                    'customer_phone' => $address['telephone'] ?? '',
                    'postcode' => $address['postcode'],
                    'street' => $address['street'],
                    'complement' => $address['complement'] ?? null,
                    'number' => $address['number'],
                    'neighborhood' => $address['neighborhood'],
                    'city' => $address['city'],
                    'region' => $address['region'],
                    'country' => 'Brasil',
                    'address_type' => $address['address_type'],
                ]
            );

            // Verifica se o endereço deverá ser salvo no cliente
            if (!empty($address['save_in_address_book'])) {
                $this->persistCustomerAddresses(
                    customer: $customer,
                    address: $salesOrderAddress
                );
            }

        }

    }

    /**
     * Persiste os endereços do cliente para uso futuro
     * @param \App\Models\CustomerEntity $customer
     * @param \App\Models\SalesOrderAddress $address
     * @return void
     */
    private function persistCustomerAddresses(
        CustomerEntity    $customer,
        SalesOrderAddress $address
    ): void
    {

        // Cria o endereço do pedido nos endereços do cliente
        CustomerAddressRepository::create([
            'customer_id' => $customer->customer_id,
            'address_type' => $address->address_type,
            'recipient_name' => $address->customer_name ?? $customer->customer_name,
            'postcode' => $address->postcode,
            'street' => $address->street,
            'number' => $address->number ?? null,
            'complement' => $address->complement ?? null,
            'neighborhood' => $address->neighborhood,
            'city' => $address->city,
            'region' => $address->region,
            'country' => $address->country ?? 'Brasil',
            'phone' => $address->customer_phone ?? null,
            'cellphone' => $address->customer_cellphone ?? null,
            'is_default_billing' => $address->address_type === 'billing',
            'is_default_shipping' => $address->address_type === 'shipping',
        ]);

    }

}
