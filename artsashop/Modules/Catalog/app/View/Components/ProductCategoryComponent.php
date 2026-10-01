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
namespace Modules\Catalog\View\Components;

use Idea\Framework\Repository\Eav\EavAttributesCategoryRepository;
use Illuminate\View\Component;
use Illuminate\View\View;

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
            $category = EavAttributesCategoryRepository::getCategoryByAttributeSetId(
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
