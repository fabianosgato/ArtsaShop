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
                'newProducts' => app(CatalogProductService::class)->getNewProducts(12),
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
                    'title' => $brands->seo_page_title,
                    'description' => $brands->seo_meta_description,
                    'canonical' => "",
                    'og:locale' => "pt_BR",
                    'og:type' => "website",
                    'og:title' => "{$brands->seo_page_title}",
                    'og:description' => $brands->seo_meta_description,
                    'og:site_name' => "{$brands->seo_page_title}",
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
