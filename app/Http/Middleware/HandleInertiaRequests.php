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
 */

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Modules\Catalog\Services\CatalogCategoryProductService;
use Modules\Checkout\Services\CheckoutCartService;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app'; // views/app.blade.php

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {

        // Retorna a loja atual
        $store = app('currentStore');

        // Categorias do menu de navegação
        $categories = app(CatalogCategoryProductService::class)->getMenuCategories();

        // Resolve categoria ativa baseada no slug atual
        $activeCategoryId = null;
        $activePathIds = [];

        $slug = trim($request->path(), '/');

        if ($slug) {
            $activePathIds = app(CatalogCategoryProductService::class)
                ->buildActivePathIdsFromTree($categories, $slug);
            if (! empty($activePathIds)) {
                $activeCategoryId = end($activePathIds);
            }
        }

        if ($activeCategoryId) {
            $categories = app(CatalogCategoryProductService::class)->applyActiveState(
                $categories,
                $activeCategoryId,
                $activePathIds
            );
        }

        return array_merge(parent::share($request), [
            'appName' => $store->store_name,
            'appUrl' => asset('/'),
            'assetUrl' => asset('/'),
            'currentStore' => $store,

            'route' => [
                'name' => $request->route()?->getName(),
            ],

            // Categorias para o menu de navegação
            'categories' => $categories,
            'activeCategoryId' => $activeCategoryId,
            'activePathIds' => $activePathIds,

            // Configuração geral da busca
            'searchConfig' => [
                'minQueryLength' => getConfigData('catalog/search/min_query_length'),
                'maxQueryLength' => getConfigData('catalog/search/max_query_length'),
                'maxQueryWords' => getConfigData('catalog/search/max_query_words'),
            ],

            'auth' => [
                'customer' => $request->user('customer')?->only('customer_id', 'customer_name', 'customer_email'),
            ],

            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],

            'store' => [
                'code' => app('currentStore')->code,
                'layout' => app('currentStore')->layout,
            ],

            'pagarmePublicKey' => fn () => getPagarmePublicKey(),
            'csrf_token' => fn () => csrf_token(),

            // Retorna a localidade do cliente
            'userLocation' => fn () => $request->session()->get('user_location'),

            // Retorna as informações do carrinho
            'cart' => fn () => app(CheckoutCartService::class)->getSummary(),

        ]);
    }
}
