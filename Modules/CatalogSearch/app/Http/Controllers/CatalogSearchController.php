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

namespace Modules\CatalogSearch\Http\Controllers;

use App\Http\Controllers\Controller;
use Idea\Framework\Contracts\Seo\SeoStaticPage;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Repository\SearchRepository;
use Idea\Framework\Seo\Traits\HasSeoResponse;
use Illuminate\Http\Request;

class CatalogSearchController extends Controller
{

    use HasSeoResponse;

    /**
     * Display a listing of the resource.
     */
    public function result(Request $request)
    {

        // Cria o array para busca
        $requestData = [
            'word' => trim($request->input('q', '')),
            'prices' => $request->input('prices', ''),
            'category' => $request->input('category', []),
            'selected_attributes' => $request->input('selected_attributes', []),
        ];

        // Realiza a busca de Produtos
        $products = SearchRepository::searchProductsPagination(
            requestData: $requestData
        );

        $this->getSeoMetaTags(
            new SeoStaticPage(
                code:'catalogsearch',
                title: "Sua busca com o total de {$products->total()} registros ",
                description: "Loja online com variedade de produtos para casa, cozinha, utilidades e mais. Compre com facilidade e receba em todo o Brasil.",
                noIndex: true,
                noFollow: true
            )
        );

        return view('catalogsearch::frontend.catalogsearch-products', [
            'term' => $requestData['word'],
            'products' => $products,
        ]);

    }

    /**
     * Retorna sugestões da busca
     */
    public function suggestions(Request $request): \Illuminate\Http\JsonResponse
    {

        $word = trim($request->input('q', ''));

        // Valida a quantidade de itens da busca
        if (mb_strlen($word) < getConfigData('catalog/search/min_query_length')) {
            return response()->json([
                'products' => [],
                'total' => 0,
                'url' => route('catalogsearch.result', ['q' => $word]),
                'message' => "Informe quantidade maior que ".getConfigData('catalog/search/min_query_length')
            ]);
        }

        $products = CatalogProductsRepository::searchProductsSuggestion(
            word: $word
        );

        return response()->json([
            'products' => $products->items(),
            'total' => $products->total(),
            'url' => route('catalogsearch.result', [
                'q' => $word
            ])
        ]);
    }

}
