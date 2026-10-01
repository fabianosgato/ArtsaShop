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

namespace Modules\Sales\Services;

use App\Models\SalesOrderQuote;
use Idea\Framework\Repository\Sales\SalesOrderQuoteAddressRepository;
use Idea\Framework\Repository\Sales\SalesOrderQuoteCustomerRepository;
use Idea\Framework\Repository\Sales\SalesOrderQuoteItemRepository;
use Idea\Framework\Repository\Sales\SalesOrderQuoteRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Modules\SalesRules\Services\DiscountCalculatorService;
use Modules\SalesRules\Services\DiscountRuleService;

class SalesQuoteService
{

    public ?Authenticatable $customerEntity;

    public function __construct()
    {
        // Instancia a sessao do cliente
        $this->customerEntity = Auth::guard('customer')->user();
    }

    /**
     * Retorna o quote ativo da sessão atual
     */
    public function getActiveQuote(): ?SalesOrderQuote
    {

        if ($this->customerEntity) {
            // Valida se a Quote Ativa é a do cliente
            $quote = SalesOrderQuoteRepository::getActiveQuoteByCustomer(
                customerId: $this->customerEntity->customer_id
            );

            if ($quote) {
                return $quote;
            }
        }

        // Retorna a quote Ativa pelo ID da sessão
        return SalesOrderQuoteRepository::getActiveQuote(
            sessionId: session()->getId()
        );

    }

    /**
     * Deleta os itens do Quote
     * @param $quoteId
     * @return void
     */
    public function deleteQuoteItens($quoteId): void
    {

        // Remove todos os itens do carrinho
        SalesOrderQuoteItemRepository::deleteQuoteItens(
            $quoteId
        );

    }

    /**
     * Remove um item do Quote
     * @param array $cart
     * @param $productId
     * @return void
     */
    public function deleteQuoteItem(array $cart, $productId): void
    {

        // Valida se o customer está logado
        if ($this->customerEntity) {

            // Atualiza a quote ativa do cliente com a sessão atual e a retorna
            $quote = $this->attachCustomerToQuote($this->customerEntity->customer_id);

            if (!$quote) {
                // Insere/Atualiza o quote atual pela sessão
                $quote = SalesOrderQuoteRepository::saveOrUpdate([
                    'session_id' => session()->getId(),
                    'subtotal' => $cart['subtotal'],
                    'total_qty' => $cart['total_qty'],
                    'is_active' => true,
                ]);

            }

        } else {

            // Insere/Atualiza o quote atual pela sessão
            $quote = SalesOrderQuoteRepository::saveOrUpdate([
                'session_id' => session()->getId(),
                'subtotal' => $cart['subtotal'],
                'total_qty' => $cart['total_qty'],
                'is_active' => true,
            ]);

        }

        // Remove itens antigos
        SalesOrderQuoteItemRepository::deleteQuoteItem(
            $quote->quote_id,
            $productId
        );

    }

    /**
     * Cria ou atualiza o quote a partir do carrinho da sessão
     */
    public function syncFromSession(array $cart): SalesOrderQuote
    {

        // Valida se o customer está logado
        if ($this->customerEntity) {

            // Atualiza a quote ativa do cliente com a sessão atual e a retorna
            $quote = $this->attachCustomerToQuote($this->customerEntity->customer_id);

            if (!$quote) {
                // Insere/Atualiza o quote atual pela sessão
                $quote = SalesOrderQuoteRepository::saveOrUpdate([
                    'session_id' => session()->getId(),
                    'subtotal' => $cart['subtotal'],
                    'total_qty' => $cart['total_qty'],
                    'is_active' => true,
                ]);

            }

        } else {

            // Insere/Atualiza o quote atual pela sessão
            $quote = SalesOrderQuoteRepository::saveOrUpdate([
                'session_id' => session()->getId(),
                'subtotal' => $cart['subtotal'],
                'total_qty' => $cart['total_qty'],
                'is_active' => true,
            ]);

        }

        // Se existirem itens no Carrinho irão ser atualizados
        if (count($cart['items']) > 0)
            // Insere itens atuais
            foreach ($cart['items'] as $item) {
                SalesOrderQuoteItemRepository::saveOrUpdate([
                    'quote_id' => $quote->quote_id,
                    'product_id' => $item['product_id'],
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['subtotal'],
                    'product_snapshot' => json_encode($item['product']),
                ]);
            }

        return $quote;
    }

    /**
     * Atualiza o e-mail do cliente na Quote
     * @param int $quoteId
     * @param array $attributes
     * @return void
     */
    public function updateCustomerQuote(
        int    $quoteId,
        array  $attributes
    ): void
    {

        SalesOrderQuoteRepository::loadModel()::query()
            ->where(
                column: 'quote_id',
                operator: '=',
                value: $quoteId
            )
            ->update($attributes);

    }

    /**
     * Metodo usado para salvar os endereços do cliente no quote
     * @param int $quoteId
     * @param array $addresses
     * @return void
     */
    public function saveOrUpdateCustomerAddresses(
        int $quoteId,
        array $addresses
    ): void
    {

        foreach (['billing', 'shipping'] as $type) {

            if (empty($addresses[$type]['postcode'])) {
                continue;
            }

            // Insere/Atualiza o endereço do cliente no Quote
            SalesOrderQuoteAddressRepository::saveQuoteAddress(
                quoteId: $quoteId,
                addressData: [
                    'quote_id' => $quoteId,
                    'address_type' => $type,
                    'street' => $addresses[$type]['street'],
                    'neighborhood' => $addresses[$type]['neighborhood'],
                    'complement' => $addresses[$type]['complement'] ?? null,
                    'number' => $addresses[$type]['number'] ?? null,
                    'city' => $addresses[$type]['city'],
                    'region' => $addresses[$type]['region'],
                    'postcode' => $addresses[$type]['postcode'],
                    'cellphone' => $addresses[$type]['cellphone'] ?? null,
                    'telephone' => $addresses[$type]['phone'] ?? null,
                    'recipient_name' => $addresses[$type]['recipient_name'] ?? null,
                    'save_in_address_book' => $addresses['save_address'] ?? 0,
                ]
            );

        }

    }

    /**
     * Atualiza método de pagamento e desconto no quote
     */
    public function updatePaymentAndDiscount(
        int    $quoteId,
        string $paymentMethod,
        ?int   $ruleId,
        float  $discountAmount,
        float  $grandTotal
    ): void
    {
        SalesOrderQuoteRepository::loadModel()::query()
            ->where(
                column: 'quote_id',
                operator: '=',
                value: $quoteId
            )
            ->where(
                column: 'session_id',
                operator: '=',
                value: session()->getId()
            )
            ->update([
                'payment_method' => $paymentMethod,
                'discount_rule_id' => $ruleId,
                'discount_amount' => $discountAmount,
                'grand_total' => $grandTotal,
            ]);
    }

    /**
     * Revalida o desconto com base no carrinho atual
     */
    public function revalidateDiscountFromCart(array $cart): array
    {

        // Retorna a quote ativa
        $quote = $this->getActiveQuote();

        if (!$quote) {
            $cart['discount_rule_id'] = null;
            $cart['payment_method'] = null;
            $cart['discount_amount'] = null;
            $cart['grand_total'] = $cart['subtotal'];
        }

        // Define PIX como padrão apenas se ainda não existir método
        if (!$quote->payment_method) {
            $quote->payment_method = 'pix';
        }

        // GARANTE consistência com o cart
        $cart['payment_method'] = $quote->payment_method;

        // Retorna o subtotal
        $subtotal = $cart['subtotal'];

        $rules = app(DiscountRuleService::class)
            ->getRulesForPayment($quote->payment_method, $subtotal);

        if ($rules->isEmpty()) {
            $this->clearDiscount($quote->quote_id);

            $cart['discount_rule_id'] = null;
            $cart['discount_amount'] = 0;

            // NÃO apagar o payment_method
            $cart['payment_method'] = $quote->payment_method;

            $cart['grand_total'] = $cart['subtotal'];

        }

        $rule = $rules->first();

        if ($rule) {

            $discountAmount = app(DiscountCalculatorService::class)
                ->calculate($subtotal, $rule);

            $grandTotal = $subtotal - $discountAmount;

            SalesOrderQuoteRepository::loadModel()::query()
                ->where(
                    column: 'quote_id',
                    operator: '=',
                    value: $quote->quote_id
                )
                ->where(
                    column: 'session_id',
                    operator: '=',
                    value: session()->getId()
                )
                ->update([
                    'discount_rule_id' => $rule->rule_id,
                    'payment_method' => $quote->payment_method,
                    'discount_amount' => $discountAmount,
                    'grand_total' => $grandTotal,
                ]);

            $cart['discount_rule_id'] = $rule->rule_id;
            $cart['payment_method'] = $quote->payment_method;
            $cart['discount_amount'] = $discountAmount;
            $cart['grand_total'] = $grandTotal;

        } else {
            SalesOrderQuoteRepository::loadModel()::query()
                ->where(
                    column: 'quote_id',
                    operator: '=',
                    value: $quote->quote_id
                )
                ->where(
                    column: 'session_id',
                    operator: '=',
                    value: session()->getId()
                )
                ->update([
                    'payment_method' => $quote->payment_method,
                    'discount_amount' => 0,
                    'grand_total' => $subtotal,
                ]);
        }

        return $cart;

    }

    /**
     * Limpa desconto do quote
     */
    public function clearDiscount(int $quoteId): void
    {
        SalesOrderQuoteRepository::loadModel()::query()
            ->where(
                column: 'quote_id',
                operator: '=',
                value: $quoteId
            )
            ->where(
                column: 'session_id',
                operator: '=',
                value: session()->getId()
            )
            ->update([
                'discount_rule_id' => null,
                'discount_amount' => 0,
                'grand_total' => null,
                'payment_method' => null,
            ]);
    }

    /**
     * Associa um customer ao quote (promoção do quote)
     */
    public function attachCustomerToQuote(int $customerId): ?SalesOrderQuote
    {

        // Valida se a sessao está ativa
        if (session()->getId()) {

            // Salva o relacionamento do Quote com o usuario
            return SalesOrderQuoteCustomerRepository::updateQuoteCustomer(
                sessionId: session()->getId(),
                customerId: $customerId
            );

        }

        return null;

    }

    /**
     * Associa um customer ao quote (promoção do quote)
     */
    public function attachCustomerToQuoteId(int $customerId, int $quoteId): ?SalesOrderQuote
    {
        // Salva o relacionamento do Quote com o usuario
        return SalesOrderQuoteCustomerRepository::createQuoteCustomer(
            quoteId: $quoteId,
            customerId: $customerId
        );
    }

    /**
     * Retorna o quote consolidado para o placeOrder
     */
    public function get(): array
    {

        // Retorna o quote ativo
        $quote = $this->getActiveQuote();

        if (!$quote) {
            throw new \RuntimeException('Quote ativo não encontrado.');
        }

        $sessionCart = session()->get('cart', [
            'items' => [],
            'total_qty' => 0,
            'subtotal' => 0,
        ]);

        // Retorna os dados do quote
        return [
            'quote_id' => $quote->quote_id,
            'items' => $sessionCart['items'],
            'total_qty' => $sessionCart['total_qty'],
            'subtotal' => $sessionCart['subtotal'],
            'shipping_cost' => 0,
            'payment_method' => $quote->payment_method,
            'discount_amount' => (float)$quote->discount_amount,
            'discount_rule_id' => $quote->discount_rule_id,
            'grand_total' => (float)(
                $quote->grand_total !== null
                    ? $quote->grand_total
                    : $sessionCart['subtotal']
                ),
            'customer_name' => $quote->customer_name,
            'cutomer_email' => $quote->customer_email,
            'customer_create_account' => $quote->customer_create_account,
            'customer_address_billing' => SalesOrderQuoteAddressRepository::getQuoteAddress(
                quoteId: $quote->quote_id,
                addressType:'billing'
            ),
            'customer_address_shipping' => SalesOrderQuoteAddressRepository::getQuoteAddress(
                quoteId: $quote->quote_id,
                addressType:'shipping'
            ),
        ];
    }

    /**
     * Coloca os itens que estão no Quote no Carrinho
     * @param \App\Models\SalesOrderQuote $quote
     * @param $cart
     * @return void
     */
    public function loadQuoteItemsToSession(SalesOrderQuote $quote, $cart): void
    {

        foreach ($quote->items as $item) {

            $product = json_decode($item->product_snapshot, true);

            $cart['items'][$item->product_id] = [
                'product_id' => $item->product_id,
                'price' => $item->price,
                'qty' => $item->qty,
                'subtotal' => $item->subtotal,
                'product' => $product,
            ];

            $cart['total_qty'] += $item->qty;
            $cart['subtotal'] += $item->subtotal;
        }

        // Dados globais
        $cart['payment_method'] = $quote->payment_method;
        $cart['discount_amount'] = (float)$quote->discount_amount;
        $cart['discount_rule_id'] = $quote->discount_rule_id;
        $cart['grand_total'] = $quote->grand_total ?? $cart['subtotal'];

        session()->put('cart', $cart);

    }

    /**
     * Retorna a ultima quote ativa do cliente
     * @param int $customerId
     * @return \App\Models\SalesOrderQuote|null
     */
    public function getActiveQuoteByCustomer(int $customerId): ?SalesOrderQuote
    {
        return SalesOrderQuoteRepository::getActiveQuoteByCustomer($customerId);
    }

    /**
     * Normaliza os dados do Quote para a finalização do pedido
     * @param \App\Models\SalesOrderQuote $quote
     * @return array
     */
    public function normalizeQuoteForCheckout(SalesOrderQuote $quote): array
    {

        $items = [];
        $subtotal = 0;
        $totalQty = 0;

        foreach ($quote->items as $item) {
            $product = json_decode($item->product_snapshot, true);

            $items[$item->product_id] = [
                'product_id' => $item->product_id,
                'price' => $item->price,
                'qty' => $item->qty,
                'subtotal' => $item->subtotal,
                'product' => $product,
            ];

            $subtotal += $item->subtotal;
            $totalQty += $item->qty;
        }

        $discount = [];

        if ($quote->discount_rule_id) {
            $discount = app(DiscountRuleService::class)->getDiscountRule(
                $quote->discount_rule_id
            );
        }

        $quoteData = [
            'quote_id' => $quote->quote_id,
            'customer_email' => $quote->customer_email,
            'customer_name' => $quote->customer_name,
            'customer_create_account' => $quote->customer_create_account,
            'items' => $items,
            'total_qty' => $totalQty,
            'subtotal' => $subtotal,
            'shipping_cost' => $quote->shipping_cost ?? 0,
            'payment_method' => $quote->payment_method,
            'discount_amount' => (float) $quote->discount_amount,
            'discount_rule_id' => $quote->discount_rule_id,
            'discount_data' => $discount,
            'grand_total' => $quote->grand_total ?? $subtotal,
        ];

        // Valida se o quote ja possui o CustomerName
        if ($quote->customer_name)
            $quoteData['customer_name'] = $quote->customer_name;

        // Valida se o quote ja possui o CustomerName
        if ($quote->customer_create_account)
            $quoteData['customer_create_account'] = $quote->customer_create_account;

        $quoteData['customer_address_billing'] = SalesOrderQuoteAddressRepository::getQuoteAddress(
            quoteId: $quote->quote_id,
            addressType:'billing'
        );

        $quoteData['customer_address_shipping'] = SalesOrderQuoteAddressRepository::getQuoteAddress(
            quoteId: $quote->quote_id,
            addressType:'shipping'
        );

        return $quoteData;

    }

    /**
     * Deleta uma quote do sistema
     */
    public function deactivateAndDeleteQuote(int $quoteId): void
    {
        SalesOrderQuoteRepository::deleteQuote(
            $quoteId
        );
    }

}
