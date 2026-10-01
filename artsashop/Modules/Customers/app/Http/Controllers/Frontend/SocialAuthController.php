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
namespace Modules\Customers\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Modules\Customers\Services\CustomerAuthService;

class SocialAuthController extends Controller
{

    public function redirect(string $provider)
    {
        // Verfica se o cliente veio do checkout
        if (request()->get('checkout')) {
            session()->put('checkout.social_login', true);
        }

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider, CustomerAuthService $authService)
    {

        $socialUser = Socialite::driver($provider)->stateless()->user();

        // Valida e cria os dados do cliente vindo do Google/Facebook
        $customer = $authService->findOrCreateSocialUser([
            'email'         => $socialUser->getEmail(),
            'name'          => $socialUser->getName(),
            'provider'      => $provider,
            'provider_id'   => $socialUser->getId(),
        ]);

        // Realiza o login do cliente
        Auth::guard('customer')->login($customer);

        // Verifica se o cliente veio do checkout
        $fromCheckout = session()->pull('checkout.social_login');

        if ($fromCheckout) {
            // Redireciona o cliente para o passo de completar o endereço no checkout
            return redirect()->route('checkout.onepage.addresses');

        } else {
            // Verficar se o cliente possui CPF/CNPJ
            if (empty($customer->vat_number)) {
                // Redireciona o cliente para completar o cadastro
                return redirect()->route('account.completeProfile');
            }

            // Redireciona o cliente para o painel
            return redirect()->intended(route('account.index'));

        }

    }

}
