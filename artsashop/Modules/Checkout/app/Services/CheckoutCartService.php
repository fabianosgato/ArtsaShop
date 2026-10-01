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
namespace Modules\Checkout\Services;

use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Illuminate\Support\Facades\Session;
use Modules\Checkout\DTO\CartItemDTO;
use Modules\Sales\Services\SalesQuoteService;

class CheckoutCartService
{
    protected string $sessionKey = 'cart';

    public function __construct(
        protected SalesQuoteService $salesQuoteService
    )
    {

    }

    /**
     * Retorna o carrinho da sessão
     */
    public function get(): array
    {

        $cart = session()->get($this->sessionKey);

        if (!empty($cart['items'])) {

            foreach ($cart['items'] as $item) {
                // Retorna o produto do Carrinho
                $product = CatalogProductsRepository::getProductById($item['product_id'])->toArray();

                if ($product['status_key'] == 'out-of-stock') {

                    // Remove o item do carrinho
                    // Remove o item da sessão do Carrinho
                    unset($cart['items'][$item['product_id']]);

                    // Remove 1 item do quote
                    $this->salesQuoteService->deleteQuoteItem($cart, $item['product_id']);

                    // Mensagem de produto sem estoque
                    Session::flash('error', "O Produto {$product['name']} não está mais disponível para compra");

                }

            }

            // Recalcula o carrinho e sincroniza o quote
            $this->recalculateAndSync($cart);


        }

        // Retorna os dados do Carrinho
        return session()->get($this->sessionKey, [
            'items'      => [],
            'total_qty' => 0,
            'subtotal'  => 0,
        ]);

    }

    /**
     * Adiciona item ao carrinho
     */
    public function add(CartItemDTO $item): void
    {

        // valida estoque ANTES de adicionar
        app(StockService::class)->validate(
            $item->product_id,
            $item->qty
        );

        $cart = $this->get();

        if (isset($cart['items'][$item->product_id])) {
            $cart['items'][$item->product_id]['qty'] += $item->qty;
        } else {
            $cart['items'][$item->product_id] = [
                'product_id' => $item->product_id,
                'price'      => $item->price,
                'qty'        => $item->qty,
                'product'    => $item->product,
            ];
        }

        $this->recalculateAndSync($cart);

        logger()->info('ADD TO CART SESSION', [
            'session_id' => session()->getId(),
            'session_name' => session()->getName(),
            'session_started' => session()->isStarted(),
            'cookie' => request()->cookie(config('session.cookie')),
            'user_agent' => request()->userAgent(),
            'ip' => request()->ip(),
        ]);

    }

    /**
     * Atualiza a quantidade de um item
     */
    public function update(int $productId, int $qty): void
    {

        // Recupera os itens do Carrinho
        $cart = $this->get();

        if (! isset($cart['items'][$productId])) {
            return;
        }

        if ($qty <= 0) {
            unset($cart['items'][$productId]);
        } else {
            $cart['items'][$productId]['qty'] = $qty;
        }

        $this->recalculateAndSync($cart);

    }

    /**
     * Atualiza a quantidade de um item
     */
    public function removeItem(int $productId): void
    {

        // Recupera os itens do Carrinho
        $cart = $this->get();

        if (! isset($cart['items'][$productId])) {
            return;
        }

        // Remove o item da sessão do Carrinho
        unset($cart['items'][$productId]);

        // Remove 1 item do quote
        $this->salesQuoteService->deleteQuoteItem($cart, $productId);

        // Recalcula o carrinho e sincroniza o quote
        $this->recalculateAndSync($cart);

    }

    /**
     * Remove todos os itens do carrinho
     */
    public function clear(): void
    {

        // Limpa a sessao do carrinho
        session()->forget($this->sessionKey);

        // Limpa desconto e pagamento do quote da sessão
        if ($quote = $this->salesQuoteService->getActiveQuote()) {
            $this->salesQuoteService->clearDiscount($quote->quote_id);
            $this->salesQuoteService->deleteQuoteItens($quote->quote_id);
        }


    }

    /**
     * Recalcula subtotais, persiste sessão e sincroniza quote
     */
    protected function recalculateAndSync(array $cart): void
    {
        $cart['total_qty'] = 0;
        $cart['subtotal']  = 0;

        // NÃO deve resetar mais esses campos aqui
        // $cart['discount_rule_id'] = 0;
        // $cart['payment_method'] = null;
        // $cart['discount_amount'] = 0;

        if (count($cart['items']) > 0) {
            foreach ($cart['items'] as &$item) {
                $item['subtotal'] = $item['price'] * $item['qty'];
                $cart['total_qty'] += $item['qty'];
                $cart['subtotal']  += $item['subtotal'];
            }
        } else {
            $cart['items'] = [];
        }

        // Subtotal base
        $cart['grand_total'] = $cart['subtotal'];

        // SINCRONIZA COM QUOTE PRIMEIRO
        $quote = $this->salesQuoteService->syncFromSession($cart);

        // RECUPERA ESTADO DO QUOTE (SOURCE OF TRUTH)
        if ($quote) {
            $cart['payment_method'] = $quote->payment_method;
            $cart['discount_rule_id'] = $quote->discount_rule_id;
            $cart['discount_amount'] = (float) $quote->discount_amount;
            $cart['grand_total'] = $quote->grand_total ?? $cart['subtotal'];
        }

        // REVALIDA DESCONTO
        $cart = $this->salesQuoteService->revalidateDiscountFromCart($cart);

        // GARANTE QUE O CART REFLETE O QUOTE FINAL
        $quote = $this->salesQuoteService->getActiveQuote();

        if ($quote) {
            $cart['payment_method'] = $quote->payment_method;
            $cart['discount_rule_id'] = $quote->discount_rule_id;
            $cart['discount_amount'] = (float) $quote->discount_amount;
            $cart['grand_total'] = $quote->grand_total ?? $cart['subtotal'];
        }

        // Atualiza sessão
        session()->put($this->sessionKey, $cart);
    }

    /**
     * Retorna um resumo do carrinho (mini-cart / AJAX)
     */
    public function getSummary(): array
    {
        $cart = $this->get();

        return [
            'items_count'  => count($cart['items']), // SKUs distintos
            'total_qty'    => $cart['total_qty'],    // Quantidade total
            'subtotal'     => $cart['subtotal'],     // Valor bruto
            'subtotal_fmt' => number_format($cart['subtotal'], 2, ',', '.'),
        ];

    }

    public function checkIsEmpty(): bool
    {

        $cart = $this->get();

        if (count($cart['items']) == 0)
            return true;

        return false;

    }

}
