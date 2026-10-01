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
use Idea\Framework\Repository\Catalog\CatalogCategoryRepository;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Seo\Traits\HasSeoResponse;

class CatalogCategoryController extends Controller
{

    use HasSeoResponse;

    /**
     * Display a listing of the resource.
     */
    public function index(int $categoryId)
    {

        // Retorna a Categoria do sistema
        $catalogCategory = CatalogCategoryRepository::getCategoryById($categoryId);

        if ($catalogCategory) {

            // Valida se há preços no request
            $prices = request()->input('prices', []);

            // Retorna os produtos da Categoria
            $products = CatalogProductsRepository::getProductsByCategoryPagination(
                categoryId: $catalogCategory->entity_id,
                perPage: 44,
                priceRange:$prices
            );

            $productsSchema = array_map(
                fn ($product) => [
                    'url' => url($product->slug_key),
                    'name' => $product->name ?? null,
                    'image' => $product->image ?? null,
                ],
                array_slice($products->items(), 0, 15)
            );

            // MetaTags da página
            $this->setSeoContext([
                'category_products' => $productsSchema
            ])->getSeoMetaTags($catalogCategory);

            // Compartilha os dados da Categoria
            view()->share('category', $catalogCategory);

            // Retorna as informações para a View
            return view('catalog::frontend.category-products', [
                'category' => $catalogCategory,
                'products' => $products,
            ]);

        }

    }

}
