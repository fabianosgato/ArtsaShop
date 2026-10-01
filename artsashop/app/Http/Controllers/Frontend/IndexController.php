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
 * Controller inicial do frontend
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Idea\Framework\Repository\Brand\CatalogProductBrandRepository;
use Idea\Framework\Repository\Catalog\CatalogCategoryRepository;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Repository\System\SysStoreRepository;
use Idea\Framework\Seo\Traits\HasSeoResponse;
use Illuminate\Support\Facades\View;
use Modules\Catalog\Services\CatalogProductService;

class IndexController extends Controller
{

    use HasSeoResponse;

    public function index()
    {

        // Identifica se a loja é a padrão
        if (app('currentStore')->code == 'default') {

            // MetaTags da página
            $this->getSeoMetaTags(
                entity: SysStoreRepository::getStoreByCode(app('currentStore')->code)
            );

            return view('frontend.page.home', [
                'newProducts' => CatalogProductService::getNewProducts(12),
                'featuredTwo' => CatalogProductService::getCategoryProductBlock(383, 8),
                'featuredThree' => CatalogProductService::getCategoryProductBlock(480, 20),
                'featuredFour' => CatalogProductService::getCategoryProductBlock(399, 20),
            ]);

        } else {

            // Valida se a loja é de Marca
            if (app('currentStore')->type == 'brand') {

                // Seciona a marca do sistema
                $brands = CatalogProductBrandRepository::getBrandByKey(app('currentStore')->code);

                View::share('seoTags', [
                    'title' => $brands['seo_page_title'],
                    'description' => $brands['seo_meta_description'],
                    'canonical' => "",
                    'og:locale' => "pt_BR",
                    'og:type' => "website",
                    'og:title' => "{$brands['seo_page_title']}",
                    'og:description' => $brands['seo_meta_description'],
                    'og:site_name' => "{$brands['seo_page_title']}",
                    'og:image:width' => "",
                    'og:image:height' => "",
                ]);

                // Retorna os produtos da Marca
                $products = CatalogProductsRepository::getProductsByBrandsPagination(
                    brandId: $brands['brand_id'],
                    perPage: 16
                );

                if ($brands)
                    return view('brands::frontend.brand', [
                        'brand' => $brands,
                        'products' => $products
                    ]);

            }

            // Valida se a loja é de Categoria
            if (app('currentStore')->type == 'category') {

                // Retorna a Categoria do sistema
                $catalogCategory = CatalogCategoryRepository::getCategoryById(app('currentStore')->parent_id);

                if ($catalogCategory) {

                    // Retorna os produtos da Categoria
                    $products = CatalogProductsRepository::getProductsByCategoryPagination(
                        categoryId: $catalogCategory->entity_id,
                        perPage: 32
                    );

                    // Compartilha as informacoes da Categoria
                    view()->share('category', $catalogCategory);

                    // Retorna as informações para a View
                    return view('catalog::frontend.category-products', [
                        'category' => $catalogCategory,
                        'products' => $products,
                    ]);

                }

            }

        }

    }

}
