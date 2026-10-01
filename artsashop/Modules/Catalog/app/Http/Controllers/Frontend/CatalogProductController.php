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
namespace Modules\Catalog\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Seo\Traits\HasSeoResponse;
use Illuminate\Support\Facades\Cache;

class CatalogProductController extends Controller
{

    use HasSeoResponse;

    public function index(int $productId)
    {

        // Retorna os dados do produto
        $catalogProduct = Cache::remember("product_page_{$productId}", 2600, function () use ($productId) {
            return CatalogProductsRepository::getProductById($productId);
        });

        if (empty($catalogProduct)) {
            abort(404);
        }

        // MetaTags da página
        $this->getSeoMetaTags(
            entity: $catalogProduct
        );

        // Compartilha as informacoes do produto
        view()->share('product', $catalogProduct);

        return view('catalog::frontend.product', [
            'product' => $catalogProduct
        ]);

    }

}
