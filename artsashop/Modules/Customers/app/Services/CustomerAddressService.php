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
