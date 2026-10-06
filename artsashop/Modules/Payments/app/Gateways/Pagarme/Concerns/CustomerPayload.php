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
namespace Modules\Payments\Gateways\Pagarme\Concerns;

use App\Models\SalesOrderAddress;
use Idea\Framework\Repository\Sales\SalesOrderRepository;
use Illuminate\Support\Facades\Log;

trait CustomerPayload
{

    /**
     * Formata um telefone para o padrão utilizado pelo Pagar.me.
     *
     * Aceita telefone fixo e celular no formato:
     * (99) 9999-9999
     * (99) 99999-9999
     *
     * @param string|null $phone
     * @return array
     */
    private function formatPhone(?string $phone): array
    {

        if (empty($phone)) {
            return [
                'country_code' => '55',
                'area_code' => '',
                'number' => '',
            ];
        }

        if (!preg_match(
            '/^\((\d{2})\)\s*(\d{4,5})-(\d{4})$/',
            $phone,
            $matches
        )) {
            return [
                'country_code' => '55',
                'area_code' => '',
                'number' => '',
            ];
        }

        return [
            'country_code' => '55',
            'area_code' => $matches[1],
            'number' => $matches[2] . $matches[3],
        ];

    }

    /**
     * Formata os telefones do cliente para o Pagar.me.
     *
     * @param SalesOrderAddress $orderAddressBilling
     * @return array
     */
    private function formatCustomerPhones(
        SalesOrderAddress $orderAddressBilling
    ): array {

        $phones = [];

        // Valida se o cliente possui telefone fixo.
        if (!empty($orderAddressBilling->customer_phone)) {

            $phones['home_phone'] = $this->formatPhone(
                $orderAddressBilling->customer_phone
            );

        }

        // O celular é obrigatório no sistema.
        $phones['mobile_phone'] = $this->formatPhone(
            $orderAddressBilling->customer_cellphone
        );

        return $phones;

    }

    /**
     * Cria o payload de endereço para o Pagar.me.
     * @param SalesOrderAddress $orderAddress
     * @return array
     */
    private function createAddressPayload(
        SalesOrderAddress $orderAddress
    ): array {

        return [
            'line_1' => sprintf(
                '%s, %s, %s',
                $orderAddress->number,
                $orderAddress->street,
                $orderAddress->neighborhood ?? 'Centro'
            ),
            'line_2' => $orderAddress->complement,
            'zip_code' => preg_replace(
                '/\D/',
                '',
                $orderAddress->postcode
            ),
            'city' => $orderAddress->city,
            'state' => $orderAddress->region,
            'country' => 'BR',
        ];

    }

    /**
     * Retorna o endereço de cobrança do pedido.
     *
     * @param int $orderId
     * @return SalesOrderAddress
     */
    private function getBillingAddress(
        int $orderId
    ): SalesOrderAddress {

        $orderAddressBilling = SalesOrderRepository::getOrderAddress(
            orderId: $orderId,
            addressType: 'billing'
        )->first();

        if (!$orderAddressBilling) {
            Log::error(
                "PEDIDO SEM ENDEREÇO DE COBRANÇA PARA O ID: $orderId"
            );

            throw new \RuntimeException(
                "O pedido $orderId não possui endereço de cobrança."
            );

        }

        return $orderAddressBilling;

    }

    /**
     * Retorna o endereço de entrega do pedido.
     *
     * @param int $orderId
     * @return SalesOrderAddress
     */
    private function getShippingAddress(
        int $orderId
    ): SalesOrderAddress {

        $orderAddressShipping = SalesOrderRepository::getOrderAddress(
            $orderId,
            'shipping'
        )->first();

        if (!$orderAddressShipping) {

            Log::error(
                "PEDIDO SEM ENDEREÇO DE ENTREGA PARA O ID: $orderId"
            );

            throw new \RuntimeException(
                "O pedido $orderId não possui endereço de entrega."
            );

        }

        return $orderAddressShipping;

    }

    /**
     * Cria o payload do cliente para o Pagar.me.
     *
     * @param int $orderId
     * @return array
     */
    private function createCustomerPayload(
        int $orderId
    ): array {

        // Retorna os dados do cliente do pedido.
        $salesOrderCustomer = SalesOrderRepository::getOrderCustomer(
            $orderId
        )->first();

        if (!$salesOrderCustomer) {

            Log::error(
                "PEDIDO SEM CLIENTE PARA O ID: $orderId"
            );

            throw new \RuntimeException(
                "O pedido $orderId não possui cliente."
            );

        }

        // Recupera os endereços do pedido.
        $orderAddressBilling = $this->getBillingAddress(
            $orderId
        );

        return [
            'name' => $salesOrderCustomer->customer_name,
            'type' => 'individual',
            'email' => $salesOrderCustomer->customer_email,
            'document' => preg_replace(
                '/\D/',
                '',
                $salesOrderCustomer->vat_number
            ),
            "document_type" => "CPF",
            'address' => $this->createAddressPayload(
                $orderAddressBilling
            ),
            'phones' => $this->formatCustomerPhones(
                $orderAddressBilling
            ),
        ];

    }

}
