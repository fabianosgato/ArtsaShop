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

namespace Modules\Checkout\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Idea\Framework\Repository\Sales\SalesOrderPaymentRepository;
use Idea\Framework\Repository\Sales\SalesOrderRepository;
use Idea\Framework\Seo\Contracts\SeoStaticPage;
use Idea\Framework\Seo\Traits\HasSeoResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Checkout\Services\CheckoutCartService;
use Modules\Sales\Services\SalesOrderPlacementService;
use Modules\Sales\Services\SalesQuoteService;
use Modules\SalesRules\Services\DiscountCalculatorService;
use Modules\SalesRules\Services\DiscountRuleService;

class CheckoutController extends Controller
{

    use HasSeoResponse;

    public function __construct(
        protected SalesQuoteService   $salesQuoteService,
        protected CheckoutCartService $cartService,
        protected DiscountRuleService $discountRuleService,
        protected DiscountCalculatorService $discountCalculatorService
    )
    {
    }

    /**
     * Passo 1: Action principal do ckeckout
     */
    public function index()
    {

        // Titulo da página
        $this->getSeoMetaTags(
            new SeoStaticPage('checkout', 'Finalização da Compra')
        );

        // Valida se o carrinho não está vazio
        if ($this->cartService->checkIsEmpty())
            return redirect()
                ->route('checkout.cart')
                ->with('error', 'Seu Carrinho está vazio');

        /** Retorna o cliente se ele estiver Logado */
        $customer = Auth::guard('customer')->user();

        /** Quote ativo da sessão */
        $quoteModel = $this->salesQuoteService->getActiveQuote();

        /**
         * Se não existe quote ainda, retorna estrutura vazia
         * (checkout vazio ou primeiro acesso)
         */
        if (!$quoteModel) {
            // Sincroniza a quote
            $this->salesQuoteService->syncFromSession(
                cart: $this->cartService->get()
            );

            /** Quote ativo da sessão */
            $quoteModel = $this->salesQuoteService->getActiveQuote();

        }

        /**
         * Se o cliente está logado e o quote ainda não está vinculado,
         * apenas associa (não recria nada)
         */
        if ($customer) {

            $this->salesQuoteService->attachCustomerToQuote(
                customerId: $customer->customer_id
            );

            // Atualiza os dados do cliente no Quote
            $this->salesQuoteService->updateCustomerQuote(
                quoteId: $quoteModel->quote_id,
                attributes: [
                    'customer_name' => $customer->customer_name,
                    'customer_email' => $customer->customer_email,
                    'customer_create_account' => true,
                ]
            );

            $quoteModel->customer_email = $customer->email;
            $quoteModel->save();

            // Pula o "login" e vai direto pro próximo step
            return redirect()->route('checkout.onepage.addresses');

        }

        /**
         * Normaliza o quote para o formato esperado pelo Blade
         */
        $quote = $this->salesQuoteService->normalizeQuoteForCheckout($quoteModel);

        // Retorna para a view as informações da página
        return view('checkout::frontend.step-identify', [
            'quote' => $quote,
            'customer' => $customer,
        ]);

    }

    /**
     * Passo 2: Action responsavel por exibir os dados do cliente
     */
    public function information()
    {

        // Titulo da página
        $this->getSeoMetaTags(
            new SeoStaticPage('checkout', 'Finalização da Compra: Informações Pessoais')
        );

        $customer = Auth::guard('customer')->user();

        // Valida se o carrinho não está vazio
        if ($this->cartService->checkIsEmpty())
            return redirect()
                ->route('checkout.cart')
                ->with('error', 'Seu Carrinho está vazio');

        // Garante step anterior
        $quote = $this->salesQuoteService->getActiveQuote();

        // Valida se o quote do cliente está ativo
        if (!$quote || !$quote->customer_email) {
            return redirect()->route('checkout.onepage.index');
        }

        // Dados em array do Quote
        $quoteData = $this->salesQuoteService->normalizeQuoteForCheckout($quote);

        return view('checkout::frontend.step-information', [
            'quote' => $quoteData,
            'customer' => $customer,
        ]);

    }

    /**
     * Passo 3: Action responsavel por exibir o endereço do cliente
     */
    public function addresses()
    {

        // Titulo da página
        $this->getSeoMetaTags(
            new SeoStaticPage('checkout', 'Finalização da Compra: Endereço de entrega')
        );

        // Retorna o customer da sessão se houver
        $customer = Auth::guard('customer')->user();

        // Valida se o carrinho não está vazio
        if ($this->cartService->checkIsEmpty())
            return redirect()
                ->route('checkout.cart')
                ->with('error', 'Seu Carrinho está vazio');

        // Garante step anterior
        $quote = $this->salesQuoteService->getActiveQuote();

        // Valida se o quote do cliente está ativo
        if (!$quote || !$quote->customer_email) {
            return redirect()->route('checkout.onepage.index');
        }

        // Dados em array do Quote
        $quoteData = $this->salesQuoteService->normalizeQuoteForCheckout($quote);

        return view('checkout::frontend.step-addresses', [
            'quote' => $quoteData,
            'customer' => $customer,
        ]);

    }

    /**
     * Passo 4: Pagamento
     */
    public function payment()
    {

        // Titulo da página
        $this->getSeoMetaTags(
            new SeoStaticPage('checkout', 'Finalização da Compra: Pagamento')
        );

        // Retorna o Customer
        $customer = Auth::guard('customer')->user();

        // Valida se o carrinho não está vazio
        if ($this->cartService->checkIsEmpty())
            return redirect()
                ->route('checkout.cart')
                ->with('error', 'Seu Carrinho está vazio');

        // Garante step anterior
        $quote = $this->salesQuoteService->getActiveQuote();

        // Dados em array do Quote
        $quoteData = $this->salesQuoteService->normalizeQuoteForCheckout($quote);

        return view('checkout::frontend.step-payment', [
            'quote' => $quoteData,
            'customer' => $customer,
        ]);

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function success($id)
    {

        // Titulo da página
        $this->getSeoMetaTags(
            new SeoStaticPage('checkout', 'Compra realizada com Sucesso')
        );

        // Finaliza o checkout
        app(SalesOrderPlacementService::class)->clearCheckoutSessions();

        // Retorna as informações do pedido
        $salesOrder = SalesOrderRepository::getOrder($id)->get()->first();

        // Retorna as informações do pagamento
        $paymentMethod = SalesOrderPaymentRepository::getData()->where(
            column: 'order_id',
            operator: '=',
            value: $salesOrder->order_id
        )->first();

        // Retorna os dados do pagamento
        $additionalInformation = json_decode($paymentMethod->additional_information, true);

        return view('checkout::frontend.success', [
            'salesOrder' => $salesOrder,
            'additionalInformation' => $additionalInformation
        ]);

    }

    public function fail()
    {

        // Titulo da página
        $this->getSeoMetaTags(
            new SeoStaticPage('checkout', 'Finalização da Compra')
        );

        // Força a finalização do checkout
        app(SalesOrderPlacementService::class)->clearCheckoutSessions();

        // Retorna a VIEW
        return view('checkout::frontend.fail');

    }

    public function validation()
    {

        // Força a finalização do checkout
        app(SalesOrderPlacementService::class)->clearCheckoutSessions();

        // Retorna a VIEW
        return view('checkout::frontend.validation');

    }

}
