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
namespace Modules\Customers\Services;

use Idea\Framework\Repository\Customer\CustomerAddressRepository;

class CustomerAddressService
{

    public function getAddressesForCustomer(int $customerId)
    {
        return CustomerAddressRepository::getData()
            ->where('customer_id', $customerId)
            ->orderByDesc('is_default_shipping')
            ->orderByDesc('is_default_billing')
            ->get();
    }

    public function getDefaultAddress(int $customerId)
    {
        return CustomerAddressRepository::getData()
            ->where('customer_id', $customerId)
            ->where(function ($q) {
                $q->where('is_default_shipping', 1)
                    ->orWhere('is_default_billing', 1);
            })
            ->first();
    }

}
