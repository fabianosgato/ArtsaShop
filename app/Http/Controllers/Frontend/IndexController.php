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
use Idea\Framework\Repository\System\SysStoreRepository;
use Idea\Framework\Seo\Traits\HasSeoResponse;
use Inertia\Inertia;
use Modules\Catalog\Services\CatalogProductService;

class IndexController extends Controller
{

    use HasSeoResponse;

    public function index()
    {

        // MetaTags da página
        $this->getSeoMetaTags(
            entity: SysStoreRepository::getStoreByCode(app('currentStore')->code)
        );

        // Busca produtos para a home
        $newProducts = app(CatalogProductService::class)->getNewProducts(12);
        $featuredProducts = app(CatalogProductService::class)->getCategoryProductBlock(489, 20);

        // Retorna via Inertia (Vue)
        return Inertia::render('Home', [
            'featuredProducts' => $featuredProducts,
            'newProducts' => $newProducts,
        ]);

    }

}
