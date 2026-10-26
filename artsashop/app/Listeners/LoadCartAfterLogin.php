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
namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Modules\Customers\Services\CheckoutCustomerService;

class LoadCartAfterLogin
{
    public function __construct(
        protected CheckoutCustomerService $checkoutCustomerService,
    )
    {
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        // Atualiza as informaçoes do carrinho do cliente
        // $this->checkoutCustomerService->quoteToCustomer();
    }

}
