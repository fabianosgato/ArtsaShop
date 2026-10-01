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

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Auth;
use Modules\Checkout\Services\CheckoutCartService;
use Modules\Sales\Services\SalesQuoteService;

class SaveCartBeforeLogout
{
    public function __construct(
        protected CheckoutCartService $cartService,
        protected SalesQuoteService   $quoteService
    )
    {
    }

    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {

        // Retorna as informações do cliente
        $customer = Auth::guard('customer')->user();

        if ($customer) {

            // Retorna a sessão do carrinho
            $sessionCart = $this->cartService->get();

            /**
             * Existe carrinho na sessão?
             * Ele tem prioridade
             */
            if (!empty($sessionCart['items'])) {

                // Retorna a quote ativa
                $quote = $this->quoteService->getActiveQuote();

                if ($quote) {
                    // Atualiza os dados do cliente no Quote
                    $this->quoteService->updateCustomerQuote(
                        quoteId: $quote->quote_id,
                        attributes: [
                            'customer_email' => $customer->customer_email,
                            'customer_name' => $customer->customer_name,
                            'customer_create_account' => 0
                        ]
                    );

                    // Vincula o quote da sessão ao cliente logado
                    $this->quoteService->attachCustomerToQuoteId(
                        customerId: $customer->customer_id,
                        quoteId:$quote->quote_id
                    );

                }

                return;
            }

            // Limpa o carrinho da sessão
            session()->forget('cart');

        }

    }

}

