<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('checkout')->group(function () {

    // Rotas definidas para o Carrinho de Compras
    Route::prefix('cart')->group(function () {

        // Adiciona o produto ao Carrinho de Compras
        Route::post('addToCart', [Modules\Checkout\Http\Controllers\Frontend\CartController::class, 'addToCart'])
            ->name('checkout.addTo');

        // Adiciona o produto ao carrinho via Ajax
        Route::post('add-to-cart-ajax', [Modules\Checkout\Http\Controllers\Frontend\CartController::class, 'addToCartAjax'])
            ->name('cart.add.ajax');

        Route::post('remove', [Modules\Checkout\Http\Controllers\Frontend\CartController::class, 'removeItemCart'])
            ->name('cart.remove');

        Route::post('remove-ajax', [Modules\Checkout\Http\Controllers\Frontend\CartController::class, 'removeItemCartAjax'])
            ->name('cart.remove.ajax');

        // Limpa o carrinho
        Route::get('clearCart', [Modules\Checkout\Http\Controllers\Frontend\CartController::class, 'clearCart'])
            ->name('checkout.clear');

        // Página do carrinho de compras
        Route::get('/', [\Modules\Checkout\Http\Controllers\Frontend\CartController::class, 'cart'])
            ->name('checkout.cart');

        // Atualiza dados do Carrinho
        Route::post('updatePost', [\Modules\Checkout\Http\Controllers\Frontend\CartController::class, 'updatePost'])
            ->name('checkout.cart.updatePost');

        // Retorna apenas o topCart
        Route::get('top-cart', [\Modules\Checkout\Http\Controllers\Frontend\CartController::class, 'topCart'])
            ->name('checkout.cart.top-cart');

    });

    // Rotas do Checkout
    Route::prefix('onepage')->group(function () {

        // Passo 1: Login do cliente
        Route::get('/', [Modules\Checkout\Http\Controllers\Frontend\CheckoutController::class, 'index'])
            ->name('checkout.onepage.index');

        // Passo 2: Dados do cliente
        Route::get('/information', [
            Modules\Checkout\Http\Controllers\Frontend\CheckoutController::class, 'information'
        ])->name('checkout.onepage.information');

        // Passo 3: Endereços do cliente
        Route::get('/addresses', [
            Modules\Checkout\Http\Controllers\Frontend\CheckoutController::class, 'addresses']
        )->name('checkout.onepage.addresses');

        // Passo 4: Pagamento do Pedido
        Route::get('/payment', [
                Modules\Checkout\Http\Controllers\Frontend\CheckoutController::class, 'payment']
        )->name('checkout.onepage.payment');

        // Passo 5: Finalização do pedido
        Route::get('success/id/{id}',[
            Modules\Checkout\Http\Controllers\Frontend\CheckoutController::class, 'success'
        ])->name('checkout.onepage.success');

        // Passo 5: Falha no pagamento
        Route::get('/fail', [
                Modules\Checkout\Http\Controllers\Frontend\CheckoutController::class, 'fail']
        )->name('checkout.onepage.fail');

        // Post do Passo 1: Login do cliente
        Route::post('/identify', [
            Modules\Checkout\Http\Controllers\Frontend\CheckoutPostController::class, 'identifyPost'
        ])->name('checkout.onepage.identify.post');

        // Post do Passo 2: Dados do cliente
        Route::post('/informationPost', [
            Modules\Checkout\Http\Controllers\Frontend\CheckoutPostController::class, 'informationPost'
        ])->name('checkout.onepage.information.post');

        // Post do Passo 3: Endereços do cliente
        Route::post('/addressesPost', [
                Modules\Checkout\Http\Controllers\Frontend\CheckoutPostController::class, 'addressesPost']
        )->name('checkout.onepage.addresses.post');

        // Rota para aplicar o desconto
        Route::post('/ajax-discount', [
            Modules\Checkout\Http\Controllers\Frontend\CheckoutPostController::class, 'ajaxDiscount'
        ])->name('checkout.onepage.ajax-discount');

        // Post do Passo 3: Endereços do cliente
        Route::post('/placeOrder', [
                Modules\Checkout\Http\Controllers\Frontend\CheckoutPostController::class, 'placeOrder']
        )->name('checkout.onepage.placeOrder.post');


    });

});



