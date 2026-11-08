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
namespace Modules\Checkout\View\Components;

use Idea\Framework\Repository\System\SysAddressStateRepository;
use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\Customers\Services\CustomerAddressService;
use Modules\Customers\Services\CustomerAuthService;

class OnepageBillingComponent extends Component
{

    public $regions;

    public $customer;
    public $addresses;
    public $defaultAddress;

    public $quote;

    /**
     * Create a new component instance.
     */
    public function __construct($quote)
    {

        // Define a variável quote do pedido
        $this->quote = $quote;

        // Dados do cliente
        $this->customer = app(CustomerAuthService::class)->user();

        // Repositorio de Regioes (estados do brasil)
        $this->regions = SysAddressStateRepository::loadModel()::query()->get();

        if ($this->customer) {
            $addressService = app(CustomerAddressService::class);
            $this->addresses = $addressService->getAddressesForCustomer($this->customer->customer_id);
            $this->defaultAddress = $addressService->getDefaultAddress($this->customer->customer_id);

        } else {
            $this->addresses = collect();
            $this->defaultAddress = null;

        }

    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('checkout::frontend.components.onepage-billing-component', [
            'customer' => app(CustomerAuthService::class)->user()
        ]);
    }

}
