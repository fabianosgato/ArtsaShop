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

use App\Models\CustomerEntity;
use Idea\Framework\Repository\AbstractRepository;

class CustomerEntityRepository extends AbstractRepository
{

    protected static $model = CustomerEntity::class;

    /**
     * Cria o Cliente na base de dados
     * @param $attributes
     * @return \App\Models\CustomerEntity
     */
    public static function createCustomer($attributes):CustomerEntity
    {

        // Inicializa a Query
        $query = self::loadModel()::query();

        // Cria ou atualiza o usuário
        return $query->firstOrCreate($attributes);

    }

    /**
     * Atualiza a base com o Vatnumber do cliente
     * @param $customerId
     * @param $vatNumber
     * @return void
     */
    public static function updateCustomerDocument($customerId, $vatNumber): void
    {

        self::loadModel()::query()
            ->find($customerId)
            ->update([
                'vat_number' => $vatNumber
            ]);

    }

    /**
     * Filtra o cliente pelo e-mail
     * @param $customerEmail
     * @return ?\App\Models\CustomerEntity
     */
    public static function getCustomerByEmail($customerEmail): ?CustomerEntity
    {

        // Inicializa a query
        $query = self::loadModel()::query();

        // filtra o cliente pelo e-mail
        $customer = $query->where(
            column: 'customer_email',
            operator: '=',
            value: $customerEmail
        );

        if ($customer->exists())
            return $customer->first();

        return null;

    }

}
