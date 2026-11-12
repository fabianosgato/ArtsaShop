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
use Inertia\Inertia;
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

            // Busca produtos para a home
            $newProducts = app(CatalogProductService::class)->getNewProducts(12);
            $featuredProducts = app(CatalogProductService::class)->getCategoryProductBlock(489, 20);
            $categories = \Idea\Framework\Repository\Catalog\CatalogCategoryRepository::getCategoriesTree();

            // Retorna via Inertia (Vue)
            return Inertia::render('Home', [
                'featuredProducts' => $featuredProducts,
                'categories' => $categories,
                'newProducts' => $newProducts,
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
                    return Inertia::render('Brand', [
                        'brand' => [
                            'brand_id' => $brands['brand_id'],
                            'brand_name' => $brands->brand_name,
                            'brand_key' => $brands->brand_key,
                            'seo_page_title' => $brands->seo_page_title,
                            'seo_meta_description' => $brands->seo_meta_description,
                        ],
                        'products' => $products,
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
                    View::share('category', $catalogCategory);

                    // Retorna as informações via Inertia
                    return Inertia::render('CategoryProducts', [
                        'category' => [
                            'entity_id' => $catalogCategory->entity_id,
                            'category' => $catalogCategory->category,
                            'category_name' => $catalogCategory->category_name,
                            'slug_key' => $catalogCategory->slug_key,
                        ],
                        'products' => $products,
                        'filters' => [
                            'brands' => \Idea\Framework\Repository\Brand\CatalogProductBrandRepository::getBrands(100),
                            'categories' => \Idea\Framework\Repository\Catalog\CatalogCategoryRepository::getCategoriesTree(),
                            'priceRanges' => [
                                ['min' => 0, 'max' => 100],
                                ['min' => 100, 'max' => 500],
                                ['min' => 500, 'max' => 1000],
                                ['min' => 1000, 'max' => null],
                            ],
                        ],
                    ]);

                }

            }

        }

    }

}
