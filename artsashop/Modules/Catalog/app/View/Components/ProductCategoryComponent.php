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

use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\Catalog\Services\CatalogCategoryProductService;

class ProductCategoryComponent extends Component
{

    public array $category;

    /**
     * Create a new component instance.
     */
    public function __construct($product)
    {

        if (empty($product['category_name']) && empty($product['category_slug_key'])) {
            // Retorna a categoria do Grupo de Atributos
            $category = CatalogCategoryProductService::getCategoryByAttributeSetId(
                attributeSetId:$product['attribute_set_id']
            );

            $this->category = [
                'slug_key' => $category->slug_key,
                'category' => $category->category,
            ];

        } else {
            $this->category = [
                'slug_key' => $product['category_slug_key'],
                'category' => $product['category_name'],
            ];

        }

    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('catalog::frontend.components.product-category-component');
    }
}
