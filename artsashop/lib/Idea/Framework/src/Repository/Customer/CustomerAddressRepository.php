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

namespace Idea\Framework\Repository\Customer;

use App\Models\CustomerAddressEntity;
use Idea\Framework\Repository\AbstractRepository;

class CustomerAddressRepository extends AbstractRepository
{

    protected static $model =  CustomerAddressEntity::class;

    /**
     * Retoorna o endereço padrao do cliente
     * @param $customerId
     * @param $addressType
     * @return \App\Models\CustomerAddressEntity
     */
    public static function getDefaultAddressTypeForCustomerId($customerId, $addressType): CustomerAddressEntity
    {

        // Inicializa a Query
        $address = self::getData();

        // Busca o endereço de Billing
        $address->where(
            column: 'customer_id',
            operator: '=',
            value: $customerId
        );

        if ($addressType == 'billing') {
            $address->where(
                column: 'is_default_billing',
                operator: '=',
                value: true
            );
        } else if ($addressType == 'shipping') {
            $address->where(
                column: 'is_default_shipping',
                operator: '=',
                value: true
            );
        }

        if ($address->exists())
            // Retorna o endereço
            return $address->first();
        else
            // Sempre irá retornar o billing
            return self::getDefaultAddressTypeForCustomerId($customerId, 'billing');

    }

    /**
     * Retorna todos os endereços do cliente
     * @param $customerId
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public static function getAddressesForCustomerId($customerId)
    {

        // Inicializa a Query
        $query = self::getData();

        // Busca pelo ID do cliente
        $query->where(
            column: 'customer_id',
            operator: '=',
            value: $customerId
        );

        if ($query->exists())
            return $query->orderBy('address_id', 'desc')->get();

        return null;

    }

    /**
     * Retorna apenas um endereço do cliente
     * @param $customerId
     * @param $addressId
     * @return \Closure|\Illuminate\Database\Eloquent\Model|null
     */
    public static function getAddressForCustomerId($customerId, $addressId)
    {

        // Inicializa a Query
        $query = self::getData();

        // Busca pelo ID do cliente
        $query->where('customer_id', '=', $customerId);
        $query->where('address_id', '=', $addressId);

        if ($query->exists())
            return $query->get()->first();

        return null;

    }

    /**
     * Metodo responsavel por desativar os endereços padroes de Shipping e Billing
     * @param $customerId
     * @param $addressType
     * @return void
     */
    public static function disableAllBillingShipping($customerId, $addressType = 'billing')
    {

        // Lista todos os endereços do cliente
        $addresses = self::getAddressesForCustomerId($customerId);

        if ($addresses)
            foreach ($addresses as $address) {
                if ($addressType == 'billing') {
                    self::getData()->find($address->address_id)
                        ->update([
                            'is_default_billing' => false
                        ]);
                } else {
                    self::getData()->find($address->address_id)
                        ->update([
                            'is_default_shipping' => false
                        ]);
                }
            }

    }

    /**
     * Cria um endereço do cliente
     * @param int $customerId
     * @param string $customerName
     * @param array $attributes
     * @return void
     */
    public static function createAddress(int $customerId, string $customerName, array $attributes): void
    {

        // Inicializa a Query
        self::getData()->create([
            'customer_id' => $customerId,
            'address_type' => $attributes['address_type'],
            'recipient_name' => $customerName,
            'postcode' => $attributes['postcode'],
            'street' => $attributes['street'],
            'number' => $attributes['number'],
            'complement' => $attributes['complement'],
            'neighborhood' => $attributes['neighborhood'],
            'city' => $attributes['city'],
            'region' => $attributes['region'],
            'country' => 'BR',
            'phone' => $attributes['phone'],
            'cellphone' => $attributes['cellphone'],
            'is_default_billing' => $attributes['is_default_billing'],
            'is_default_shipping' => $attributes['is_default_shipping'],
        ]);

    }

    /**
     * Atualiza um endereço de um cliente
     * @param $attributes
     * @return void
     */
    public static function updateAddress($attributes)
    {

        // Inicializa a Query
        self::getData()->find($attributes['address_id'])
            ->update($attributes);

    }

}
