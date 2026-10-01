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

namespace Modules\CatalogSearch\Http\Controllers;

use App\Http\Controllers\Controller;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Repository\SearchRepository;
use Idea\Framework\Seo\Contracts\SeoStaticPage;
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
        $word = trim($request->get('q', ''));

        if (mb_strlen($word) < 4) {
            return response()->json([]);
        }

        $products = CatalogProductsRepository::searchProductsSuggestion(
            word: $word
        );

        return response()->json([
            'products' => $products['products'],
            'total' => $products['total'],
            'url' => route('catalogsearch.result', [
                'q' => $word
            ])
        ]);
    }

}
