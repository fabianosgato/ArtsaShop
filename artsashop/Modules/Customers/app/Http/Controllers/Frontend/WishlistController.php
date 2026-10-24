<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 *
 * É concedida permissão, gratuitamente, a qualquer pessoa que obtenha uma cópia
 * deste software e arquivos de documentação associados
 *
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */
namespace Modules\Customers\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Idea\Framework\Contracts\Seo\SeoStaticPage;
use Idea\Framework\Repository\Customer\CustomerWishlistEntityRepository;
use Idea\Framework\Seo\Traits\HasSeoResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class WishlistController extends Controller
{

    use HasSeoResponse;

    /**
     * Store a newly created resource in storage.
     */
    public function index()
    {

        // Monta o head da página
        $this->getSeoMetaTags(
            new SeoStaticPage('customer', 'Meus Favoritos')
        );

        // Valida se o cliente esta realmente autenticado
        if (Auth::guard('customer')->check()) {

            // Retorna as informações do Customer pelo ID
            $customer = Auth::guard('customer')->user();

            // Retorna os produtos favoritos do cliente
            $wishlistCatalogProducts = CustomerWishlistEntityRepository::getProduts(
                customerId: $customer->customer_id
            );

            return view('customers::frontend.wishlist', [
                'wishlistCatalogProducts' => $wishlistCatalogProducts
            ]);
        }

        // Redireciona para a página de login
        return redirect()->route('account.login')->withErrors([
            'Você precisa estar logado'
        ]);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function addWishlist(Request $request)
    {

        // Valida se o cliente esta realmente autenticado
        if (Auth::guard('customer')->check()) {

            // Dados do Cliente
            $customer = Auth::guard('customer')->user();

            CustomerWishlistEntityRepository::add(
                customerId: $customer->customer_id,
                productId:$request->get('product_id')
            );

        }

    }

    public function removeWishlist(Request $request)
    {

        // Valida se o cliente esta realmente autenticado
        if (Auth::guard('customer')->check()) {

            // Dados do Cliente
            $customer = Auth::guard('customer')->user();

            CustomerWishlistEntityRepository::remove(
                customerId: $customer->customer_id,
                productId:$request->get('product_id')
            );

        }

    }

}
