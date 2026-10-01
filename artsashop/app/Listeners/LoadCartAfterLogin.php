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
