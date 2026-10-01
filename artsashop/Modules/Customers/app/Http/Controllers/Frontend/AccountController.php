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
use Idea\Framework\Repository\Customer\CustomerAddressRepository;
use Idea\Framework\Repository\Customer\CustomerEntityRepository;
use Idea\Framework\Repository\System\SysAddressStateRepository;
use Idea\Framework\Seo\Contracts\SeoStaticPage;
use Idea\Framework\Seo\Traits\HasSeoResponse;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    use HasSeoResponse;

    /**
     * Action responsavel pela Pagina de Login do usuario.
     */
    public function login()
    {

        $this->getSeoMetaTags(
            new SeoStaticPage(
                code: 'customer',
                title: 'Painel da Conta :: Login',
                description: 'Painel da Sua conta'
            )
        );

        // Retorna a View
        return view('customers::frontend.login');

    }

    /**
     * Pagina responsavel pelo form de cadastro.
     */
    public function create()
    {

        $this->getSeoMetaTags(
            new SeoStaticPage('customer', 'Painel da Conta :: Crie sua Conta')
        );

        // Retorna a View
        return view('customers::frontend.create');
    }

    /**
     * Action usada para completar o cadastro do cliente vindo do Google/Facebook
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|object
     */
    public function completeProfile()
    {

        if (!Auth::guard('customer')->check()) {
            return redirect()->route('account.login');
        }

        $customer = Auth::guard('customer')->user();

        return view('customers::frontend.complete-profile', [
            'customer' => $customer
        ]);
    }

    /**
     * Pagina responsavel pelo "Esqueci minha senha".
     */
    public function forgotpassword()
    {

        $this->getSeoMetaTags(
            new SeoStaticPage('customer', 'Esqueci Minha Senha')
        );

        return view('customers::frontend.forgotpassword');
    }

    /**
     * Action para reset da senha
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function resetPassword($token)
    {

        $this->getSeoMetaTags(
            new SeoStaticPage('customer', 'Troca de senha')
        );

        return view('customers::frontend.resetpassword', [
            'token' => $token
        ]);

    }

    /**
     * Página inicial do painel do Cliente.
     */
    public function index()
    {

        $this->getSeoMetaTags(
            new SeoStaticPage('customer', 'Meu Painel')
        );

        // Valida se o cliente esta realmente autenticado
        if (Auth::guard('customer')->check()) {

            // Retorna as informações do Customer pelo ID
            $customer = Auth::guard('customer')->user();

            // Retorna com os dados do Cliente
            return view('customers::frontend.account', [
                'customer' => CustomerEntityRepository::getData()->find(
                    id: $customer->customer_id
                )
            ]);
        }

        // Redireciona para a página de login
        return redirect()->route('account.login')->withErrors([
            'Você precisa estar logado'
        ]);

    }

    /**
     * Action responsavel por editar os dados pessoais do cliente
     */
    public function edit()
    {

        $this->getSeoMetaTags(
            new SeoStaticPage('customer', 'Meus Dados Pessoais')
        );

        // Valida se o cliente esta realmente autenticado
        if (Auth::guard('customer')->check()) {

            // Retorna as informações do Customer pelo ID
            $customer = Auth::guard('customer')->user();

            // Retorna os dados do Cliente
            $customerEntity = CustomerEntityRepository::getData()->find(
                id: $customer->customer_id
            );

            return view('customers::frontend.edit', [
                'customer' => $customerEntity
            ]);

        }

        // Redireciona para a página de login
        return redirect()->route('account.login')->withErrors([
            'Você precisa estar logado'
        ]);

    }

    /**
     * Action responsavel por editar os endereços do cliente
     */
    public function address()
    {

        // Monta o head da página
        $this->getSeoMetaTags(
            new SeoStaticPage('customer', 'Meus Endereços')
        );

        // Valida se o cliente esta realmente autenticado
        if (Auth::guard('customer')->check()) {

            // Retorna as informações do Customer pelo ID
            $customer = Auth::guard('customer')->user();

            $customerAddresses = CustomerAddressRepository::getAddressesForCustomerId(
                customerId: $customer->customer_id
            );

            return view('customers::frontend.address', [
                'customerAddresses' => $customerAddresses
            ]);
        }

        // Redireciona para a página de login
        return redirect()->route('account.login')->withErrors([
            'Você precisa estar logado'
        ]);

    }

    public function addressCreate()
    {

        // Monta o head da página
        $this->getSeoMetaTags(
            new SeoStaticPage('customer', 'Cadastrar Novo Endereço')
        );

        // Retorna os dados do cliente
        $customer = Auth::guard('customer')->user();

        // Valida se o cliente esta realmente autenticado
        if (Auth::guard('customer')->check()) {

            return view('customers::frontend.address-create', [
                'states' => SysAddressStateRepository::loadModel()::query()->get(),
                'customer' => $customer->toArray(),
            ]);
        }

        // Redireciona para a página de login
        return redirect()->route('account.login')->withErrors([
            'Você precisa estar logado'
        ]);

    }

    public function addressEdit($id)
    {

        // Monta o head da página
        $this->getSeoMetaTags(
            new SeoStaticPage('customer', 'Editar meus endereços')
        );

        // Valida se o cliente esta realmente autenticado
        if (Auth::guard('customer')->check()) {

            // Retorna as informações do Customer pelo ID
            $customer = Auth::guard('customer')->user();

            return view('customers::frontend.address-edit', [
                'address' => CustomerAddressRepository::getAddressForCustomerId(
                    customerId: $customer->customer_id,
                    addressId: $id
                ),
                'states' => SysAddressStateRepository::loadModel()::query()->get()
            ]);
        }

        // Redireciona para a página de login
        return redirect()->route('account.login')->withErrors([
            'Você precisa estar logado'
        ]);

    }

    /**
     * Action responsavel pela visualização dos pedidos do cliente
     */
    public function orders()
    {
        // Monta o head da página
        $this->getSeoMetaTags(
            new SeoStaticPage('customer', 'Minhas Compras')
        );

        // Valida se o cliente esta realmente autenticado
        if (Auth::guard('customer')->check()) {

            // Retorna as informações do Customer pelo ID
            $customer = Auth::guard('customer')->user();

            // Retorna com os dados do Cliente
            return view('customers::frontend.orders', [
                'customer' => CustomerEntityRepository::getData()->find(
                    id: $customer->customer_id
                )
            ]);

        }

        // Redireciona para a página de login
        return redirect()->route('account.login')->withErrors([
            'Você precisa estar logado'
        ]);

    }

}
