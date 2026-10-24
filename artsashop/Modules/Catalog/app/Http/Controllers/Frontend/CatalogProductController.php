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
namespace Modules\Catalog\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Seo\Traits\HasSeoResponse;
use Idea\Framework\Services\ServiceCache;

class CatalogProductController extends Controller
{

    use HasSeoResponse;

    public function index(int $productId)
    {

        $catalogProduct =  app(ServiceCache::class)->remember(
            cacheKey: "product_page_{$productId}",
            tags:['catalog_products'],
            closure: function () use ($productId) {
                return CatalogProductsRepository::getProductById($productId);
            }
        );

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
