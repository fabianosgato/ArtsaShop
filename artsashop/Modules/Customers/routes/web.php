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

// Rotas do frontend
Route::prefix('customer')->group(function () {

    Route::prefix('acount')->group(function () {

        // Rota de Login
        Route::get('login', [\Modules\Customers\Http\Controllers\Frontend\AccountController::class, 'login'])
            ->name('account.login');

        // Rota de Cadastro do usuario
        Route::get('create', [\Modules\Customers\Http\Controllers\Frontend\AccountController::class, 'create'])
            ->name('account.create');

        // Rota para validação do e-mail do cliente
        Route::post('check-email', [
            \Modules\Customers\Http\Controllers\Frontend\CustomerController::class,
            'checkEmail'
        ])->name('account.checkEmail');

        // Rota de Esqueci Minha Senha do usuario
        Route::get('reset-password/{token}', [\Modules\Customers\Http\Controllers\Frontend\AccountController::class, 'resetPassword'])
            ->name('account.resetPassword');

        // Rota de Esqueci Minha Senha do usuario
        Route::post('reset-password-post', [\Modules\Customers\Http\Controllers\Frontend\CustomerController::class, 'resetPasswordPost'])
            ->name('account.resetPassword.post');

        // Rota de Esqueci Minha Senha do usuario
        Route::get('forgotpassword', [\Modules\Customers\Http\Controllers\Frontend\AccountController::class, 'forgotpassword'])
            ->name('account.forgotpassword');

        // Rota eue valida o "Esqueci Minha Senha" do usuario
        Route::post('forgotpassword-post', [\Modules\Customers\Http\Controllers\Frontend\CustomerController::class, 'forgotpasswordPost'])
            ->name('account.forgotpassword.post');

        // Rota do POST de Login
        Route::post('loginPost', [\Modules\Customers\Http\Controllers\Frontend\CustomerController::class, 'loginPost'])
            ->name('account.loginPost');

        // Rota do POST de Login
        Route::post('createpost', [\Modules\Customers\Http\Controllers\Frontend\CustomerController::class, 'createpost'])
            ->name('account.createpost');

        // Realiza o POST para adicionar o produto aos favoritos do cliente
        Route::post('wishlist', [\Modules\Customers\Http\Controllers\Frontend\WishlistController::class, 'addWishlist'])
            ->name('account.wishlist.add');

        // Realiza o POST para adicionar o produto aos favoritos do cliente
        Route::post('wishlist-remove', [\Modules\Customers\Http\Controllers\Frontend\WishlistController::class, 'removeWishlist'])
            ->name('account.wishlist.remove');

        Route::get('auth/{provider}', [\Modules\Customers\Http\Controllers\Frontend\SocialAuthController::class, 'redirect'])
            ->name('account.social.redirect');

        Route::get('auth/{provider}/callback', [\Modules\Customers\Http\Controllers\Frontend\SocialAuthController::class, 'callback'])
            ->name('account.social.callback');

        Route::get('complete-profile', [\Modules\Customers\Http\Controllers\Frontend\AccountController::class, 'completeProfile'])
            ->name('account.completeProfile');

        Route::post('complete-profile-post', [\Modules\Customers\Http\Controllers\Frontend\CustomerController::class, 'completeProfilePost'])
            ->name('account.completeProfile.post');

        // Rotas do painel do cliente
        Route::middleware('auth.customer')->group(function () {

            // Página inicial do painel do cliente
            Route::get('index', [\Modules\Customers\Http\Controllers\Frontend\AccountController::class, 'index'])
                ->name('account.index');

            // Edição dos dados Pessoais
            Route::get('edit', [\Modules\Customers\Http\Controllers\Frontend\AccountController::class, 'edit'])
                ->name('account.edit');

            // Lista de endereços
            Route::get('address', [\Modules\Customers\Http\Controllers\Frontend\AccountController::class, 'address'])
                ->name('account.address');

            // Criação do endereço
            Route::get('address-create', [\Modules\Customers\Http\Controllers\Frontend\AccountController::class, 'addressCreate'])
                ->name('account.addressCreate');

            // Edição dos endereços
            Route::get('address-edit/{id}', [\Modules\Customers\Http\Controllers\Frontend\AccountController::class, 'addressEdit'])
                ->name('account.addressedit');

            // Edição dos dados Pessoais
            Route::get('orders', [\Modules\Customers\Http\Controllers\Frontend\AccountController::class, 'orders'])
                ->name('account.orders');

            // Edição dos dados Pessoais
            Route::get('wishlist', [\Modules\Customers\Http\Controllers\Frontend\WishlistController::class, 'index'])
                ->name('account.wishlist.index');

            // Logout da conta do cliente
            Route::get('logout', [\Modules\Customers\Http\Controllers\Frontend\CustomerController::class, 'logout'])->name('account.logout');

            // Edição dos dados Pessoais
            Route::post('editpost', [\Modules\Customers\Http\Controllers\Frontend\CustomerController::class, 'editPost'])
                ->name('account.editpost');

            // Cadastro de novo endereço
            Route::post('address-create-post', [\Modules\Customers\Http\Controllers\Frontend\CustomerController::class, 'addressCreatePost'])
                ->name('account.addressCreate.post');

            // Edição dos endereços
            Route::post('address-edit-post', [\Modules\Customers\Http\Controllers\Frontend\CustomerController::class, 'addressEditPost'])
                ->name('account.addressedit.post');

        });

    });

});
