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
use Idea\Framework\Repository\Customer\CustomerAddressRepository;
use Idea\Framework\Repository\Customer\CustomerEntityRepository;
use Idea\Framework\Repository\Sales\SalesOrderQuoteCustomerRepository;
use Idea\Framework\Repository\Sales\SalesOrderQuoteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Checkout\Http\Requests\CheckoutAddressesRegisterRequest;
use Modules\Checkout\Http\Requests\CheckoutCustomerRegisterRequest;
use Modules\Checkout\Http\Requests\CheckoutPlaceOrderRequest;
use Modules\Checkout\Services\CheckoutCartService;
use Modules\Customers\Http\Requests\CustomerEmailRequest;
use Modules\Sales\Services\SalesOrderPlacementService;
use Modules\Sales\Services\SalesQuoteService;
use Modules\SalesRules\Services\DiscountCalculatorService;
use Modules\SalesRules\Services\DiscountRuleService;

class CheckoutPostController extends Controller
{

    public function __construct(
        protected SalesQuoteService         $salesQuoteService,
        protected CheckoutCartService       $cartService,
        protected DiscountRuleService       $discountRuleService,
        protected DiscountCalculatorService $discountCalculatorService,
        protected SalesOrderPlacementService $salesOrderPlacementService
    )
    {
    }

    /**
     * Metodo usado para realização do Login do Cliente
     */
    public function identifyPost(CustomerEmailRequest $request)
    {

        // Retorna o e-mail do cliente
        $customerEmail = $request->customer_email;

        // Adiciona o $email do cliente a sessão
        session()->put('checkout.email', $customerEmail);

        // Retorna a Quote Ativa
        $quote = $this->salesQuoteService->getActiveQuote();

        // Verifica se o cliente existe
        $customer = CustomerEntityRepository::getCustomerByEmail($customerEmail);

        // Se o cliente existir
        if ($customer) {

            // Adiciona o customer existente a sessão
            session()->put('checkout.existing_customer', true);

            // Adiciona o customerName
            $customerName = $customer->customer_name;

        } else {
            // CustomerName nao existe ainda
            $customerName = null;

        }

        if ($quote) {

            // Atualiza o email do cliente no Quote
            $this->salesQuoteService->updateCustomerQuote(
                quoteId: $quote->quote_id,
                attributes:[
                    'customer_email' => $customerEmail,
                    'customer_name' => $customerName,
                ]
            );

            if ($customer) {
                // Vincula o Quote ativo ao cliente
                SalesOrderQuoteCustomerRepository::createQuoteCustomer(
                    quoteId: $quote->quote_id,
                    customerId:$customer->customer_id
                );

            }

        }

        return redirect()->route('checkout.onepage.information');

    }

    /**
     * Realiza o Post do formulario de dados do cliente (nome/email/senha)
     * @param \Modules\Checkout\Http\Requests\CheckoutCustomerRegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function informationPost(CheckoutCustomerRegisterRequest $request)
    {

        // Retorna a quote atual
        $quote = $this->salesQuoteService->getActiveQuote();

        // Valida se o quote é valido, se nao redireciona para a página do Carrinho
        if (!$quote) {
            return redirect()->route('checkout.cart');
        }

        // Verifica cliente existente
        $customer = CustomerEntityRepository::getCustomerByEmail($request->register['email_address']);

        // Se o cliente existir
        if ($customer) {

            // Realiza o login do Customer
            Auth::guard('customer')->login($customer);

            // Atualiza a quote com o Novo ID de Sessão
            SalesOrderQuoteRepository::updateQuoteSession(
                quoteId: $quote->quote_id,
                sessionId: session()->getId()
            );

        }

        // Atualiza os dados do cliente no Quote
        $this->salesQuoteService->updateCustomerQuote(
            quoteId: $quote->quote_id,
            attributes: [
                'customer_name' => $request->register['customer_name'],
                'customer_create_account' => $request->register['customer_create_account'] ?? 0,
            ]
        );

        // senha opcional (criação futura de conta)
        if (isset($request->register['customer_create_account'])) {
            session()->put('checkout.create_account', true);
            session()->put('checkout.password', $request->register['password']);
        }

        $quote->save();

        return redirect()->route('checkout.onepage.addresses');

    }

    /**
     * Realiza o Post do formulario de dados do cliente
     * @param \Modules\Checkout\Http\Requests\CheckoutAddressesRegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addressesPost(CheckoutAddressesRegisterRequest $request)
    {

        // Retorna a quote atual
        $quote = $this->salesQuoteService->getActiveQuote();

        if (!$quote) {
            return redirect()->route('checkout.onepage.index');
        }

        // Valida se o cliente já está logado
        $customer = Auth::guard('customer')->user();

        if ($customer)
            // Se o usuario está logado atualiza o sistema do Quote
            SalesOrderQuoteCustomerRepository::createQuoteCustomer(
                quoteId: $quote->quote_id,
                customerId:$customer->customer_id
            );

        // Retorna os endereços
        $addresses = $request->all();

        // Valida se o endereço do cliente é do "address-book"
        if (($addresses['address_option'] ?? null) === 'saved') {

            // Retorna o endereço do cliente
            $addresses['billing'] = CustomerAddressRepository::getAddressForCustomerId(
                customerId:$customer->customer_id,
                addressId: $addresses['saved_address_id']
            )->toArray();

        }

        if (empty($addresses['billing']['use_different_shipping']))
            $addresses['shipping'] = $addresses['billing'];

        // Insere/Atualiza os endereços do cliente no Quote
        $this->salesQuoteService->saveOrUpdateCustomerAddresses(
            quoteId: $quote->quote_id,
            addresses: $addresses
        );

        // Redireciona para o Pagamento
        return redirect()->route('checkout.onepage.payment');

    }

    /**
     * Aplica a regra de desconto no valor
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function ajaxDiscount(Request $request)
    {

        if (!$request->ajax()) {
            abort(404);
        }

        $data = $request->validate([
            'payment_method' => 'required|string',
        ]);

        // Inicializa o Quote
        $quote = $this->salesQuoteService->get();

        $subtotal = $quote['subtotal'];
        $paymentMethod = $data['payment_method'];

        // Busca regra
        $rules = $this->discountRuleService->getRulesForPayment($paymentMethod, $subtotal);

        $discountAmount = 0;
        $ruleId = null;
        $label = null;

        if ($rules->isNotEmpty()) {
            $rule = $rules->first();
            $ruleId = $rule->rule_id;
            $label = $rule->label;

            $discountAmount = $this->discountCalculatorService->calculate($subtotal, $rule);

        }

        $grandTotal = max(0, $subtotal - $discountAmount);

        // PERSISTE NO QUOTE
        $this->salesQuoteService->updatePaymentAndDiscount(
            quoteId: $quote['quote_id'],
            paymentMethod: $paymentMethod,
            ruleId: $ruleId,
            discountAmount: $discountAmount,
            grandTotal: $grandTotal
        );

        return response()->json([
            'success' => true,
            'payment_method' => $paymentMethod,
            'discount' => [
                'rule_id' => $ruleId,
                'label' => $label,
                'amount' => $discountAmount,
            ],
            'grand_total' => $grandTotal,
        ]);

    }

    /**
     * Realiza a finalização do pedido
     * @param \Modules\Checkout\Http\Requests\CheckoutPlaceOrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function placeOrder(CheckoutPlaceOrderRequest $request)
    {

        try {

            // Retorna a quote atual
            $quote = $this->salesQuoteService->getActiveQuote();

            if (!$quote) {
                return redirect()->route('checkout.onepage.index');
            }

            // Valida se o carrinho não está vazio
            if ($this->cartService->checkIsEmpty())
                return redirect()
                    ->route('checkout.cart')
                    ->with('error', 'Seu Carrinho está vazio');

            // Realiza o pedido no sistema
            $order = $this->salesOrderPlacementService->place(
                quote: $this->salesQuoteService->get(),
                payload: $request->all()
            );

            // Caso o pedido tenha sido cancelado
            if ($order->status == 'canceled')
                return redirect()->route('checkout.onepage.fail');

            // Redireciona para a pagina de sucesso
            return redirect()->route('checkout.onepage.success', [
                'id' => $order->order_id
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();

        }

    }

}
