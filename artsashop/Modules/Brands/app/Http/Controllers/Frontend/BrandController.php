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
namespace Modules\Brands\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Idea\Framework\Repository\Brand\CatalogProductBrandRepository;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Seo\Traits\HasSeoResponse;

class BrandController extends Controller
{

    use HasSeoResponse;

    /**
     * Display a listing of the resource.
     */
    public function index(string $brandId)
    {

        // Seciona a marca do sistema
        $brands = CatalogProductBrandRepository::getBrand(intval($brandId));

        // Compartilha as informacoes do marca
        view()->share('brand', $brands);

        // Retorna os produtos da Marca
        $products = CatalogProductsRepository::getProductsByBrandsPagination(
            brandId: $brands['brand_id'],
            perPage: 16
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
        ])->getSeoMetaTags(
            entity: $brands
        );

        return view('brands::frontend.brand', [
            'brand' => $brands,
            'products' => $products
        ]);

    }

}

