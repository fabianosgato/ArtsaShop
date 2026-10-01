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

use Idea\Framework\Repository\Customer\CustomerEntityRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Checkout\Services\CheckoutCartService;
use Modules\Sales\Services\SalesQuoteService;

class CheckoutCustomerService
{

    public function __construct(
        protected CheckoutCartService $cartService,
        protected SalesQuoteService   $quoteService
    )
    {
    }

    public static function resolveOrCreate(array $quote, array $payload)
    {

        // Valida se o cliente já está logado
        if (Auth::guard('customer')->check()) {
            return Auth::guard('customer')->user();
        }

        // Valida se o cliente ja existe na base pelo e-mail
        $customer = CustomerEntityRepository::getCustomerByEmail($quote['cutomer_email']);

        // Se existir irá forçar o login
        if ($customer) {
            Auth::guard('customer')->login($customer);

            return $customer;

        }

        // Valida se o cliente está se cadastrando
        if (!$quote['customer_create_account'])
            $customerPassord = null;
        else
            $customerPassord = Hash::make($payload['register']['password']);

        // Cria customer na base de dados
        $customer = CustomerEntityRepository::createCustomer([
            'customer_name' => $quote['customer_name'],
            'customer_email' => $quote['cutomer_email'],
            'customer_passwd' => $customerPassord,
            'vat_number' => $payload['register']['vat_number']
        ]);

        // Força o login do cliente
        Auth::guard('customer')->login($customer);

        // Retorna o customer criado
        return $customer;

    }

    /**
     * Vincula o Quote ao cliente
     * @return void
     */
    public function quoteToCustomer(): void
    {

        // Retorna as informações do cliente
        $customer = Auth::guard('customer')->user();

        if ($customer) {

            /** Carrinho atual da sessão */
            $sessionCart = $this->cartService->get();

            /** Quote ativo da sessão atual */
            $quote = $this->quoteService->getActiveQuote();

            /**
             * Existe carrinho na sessão?
             * Ele tem prioridade
             */
            if (!empty($sessionCart['items']) && $quote) {

                // Vincula o quote da sessão ao cliente logado
                $this->quoteService->attachCustomerToQuoteId(
                    customerId: $customer->customer_id,
                    quoteId:$quote->quote_id
                );

            }

            /**
             * Não existe carrinho em sessão
             * Tenta recuperar quote ativo do cliente
             */
            $customerQuote = $this->quoteService->getActiveQuoteByCustomer(
                customerId: $customer->customer_id
            );

            /**
             *  Carrega itens do quote do cliente para a sessão
             */
            $this->quoteService->loadQuoteItemsToSession($customerQuote, $sessionCart);

        }

    }

}
