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
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Seo\Contracts\SeoStaticPage;
use Idea\Framework\Seo\Traits\HasSeoResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Modules\Checkout\DTO\CartItemDTO;
use Modules\Checkout\Services\CheckoutCartService;

class CartController extends Controller
{

    use HasSeoResponse;

    public function __construct(
        protected CheckoutCartService $cartService
    )
    {
    }

    /**
     * Metodo privado para adicionar ao carrinho
     * @param int $productId
     * @param int $qty
     * @return void
     */
    private function handleAddToCart(int $productId, int $qty): void
    {

        $product = CatalogProductsRepository::getProductById($productId);

        $item = new CartItemDTO(
            product_id: $product['product_id'],
            price: $product['final_price'],
            qty: $qty,
            subtotal: $product['final_price'] * $qty,
            product: $product->toArray()
        );

        $this->cartService->add($item);
    }

    /**
     * Adiciona item ao carrinho sem ajax
     */
    public function addToCart(Request $request)
    {

        $data = $request->validate([
            'product_id' => 'required|int',
            'qty'        => 'required|int|min:1',
        ]);

        try {
            $this->handleAddToCart(
                productId: $data['product_id'],
                qty: $data['qty']
            );

            return redirect()->route('checkout.cart');

        } catch (\DomainException $e) {

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }

    }

    /**
     * Adiciona item ao carrinho via AJAX
     */
    public function addToCartAjax(Request $request)
    {

        try {

            $data = $request->validate([
                'product_id' => 'required|int',
                'qty' => 'required|int|min:1',
            ]);

            $this->handleAddToCart(
                productId: $data['product_id'],
                qty: $data['qty']
            );

            return response()->json([
                'success' => true,
                'message' => 'Produto adicionado ao carrinho',
                'cart' => $this->cartService->getSummary(), // opcional
                'html' => Blade::render('<x-checkout::top-cart-component />')
            ]);

        } catch (\DomainException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }

    }

    /**
     * Limpa o carrino
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearCart()
    {

        // Limpa o carrinho
        $this->cartService->clear();

        // Redireciona novamente para o carrinho
        return redirect()->route('checkout.cart');

    }

    /**
     * Remove um item específico do carrinho
     */
    public function removeItemCart(Request $request)
    {

        $data = $request->validate([
            'product_id' => 'required|int',
        ]);

        // Quantidade 0 remove o item
        $this->cartService->update(
            productId: $data['product_id'],
            qty: 0
        );

        return redirect()->route('checkout.cart');

    }

    /**
     * Remove item do carrinho via AJAX
     */
    public function removeItemCartAjax(Request $request): \Illuminate\Http\JsonResponse
    {

        $data = $request->validate([
            'product_id' => 'required|int',
        ]);

        // Remove o item da sessão
        $this->cartService->removeItem(
            productId: $data['product_id']
        );

        return response()->json([
            'success' => true,
            'message' => 'Item removido do carrinho',
            'cart' => $this->cartService->getSummary(),
        ]);

    }

    /**
     * Atualiza os dados do carrinho como quantidade
     */
    public function updatePost(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|int',
            'qty' => 'required|int|min:1',
        ]);

        $this->cartService->update(
            productId: $data['product_id'],
            qty: $data['qty']
        );

        return response()->json([
            'success' => true,
            'message' => 'Quantidade atualizada',
            'cart' => $this->cartService->getSummary(),
        ]);
    }

    /**
     * Action da página do carrinho.
     */
    public function cart()
    {

        $this->getSeoMetaTags(
            new SeoStaticPage('cart', 'Carrinho de Compras')
        );

        return view('checkout::frontend.cart', [
            'cart' => $this->cartService->get()
        ]);

    }

    public function topCart()
    {
        return view('checkout::frontend.components.top-cart-component', [
            'cart' => $this->cartService->get()
        ]);
    }

}
