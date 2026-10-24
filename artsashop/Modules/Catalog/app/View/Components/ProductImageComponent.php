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
namespace Modules\Catalog\View\Components;

use App\Models\CatalogProduct;
use Idea\Framework\Repository\Catalog\CatalogProductMediaRepository;
use Illuminate\View\Component;
use Illuminate\View\View;

class ProductImageComponent extends Component
{
    public array $productImages;

    /**
     * Create a new component instance.
     */
    public function __construct(CatalogProduct $product)
    {
        // Retorna as imagens do produto
        $this->productImages = CatalogProductMediaRepository::getProductImagesData($product);
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('catalog::frontend.components.product-image-component');
    }

}
