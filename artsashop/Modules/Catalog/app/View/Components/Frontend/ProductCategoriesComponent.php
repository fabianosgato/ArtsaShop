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
namespace Modules\Catalog\View\Components\Frontend;

use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\Eav\Services\EavAttributeSetService;

class ProductCategoriesComponent extends Component
{

    public array $categoriesTree;

    /**
     * Create a new component instance.
     */
    public function __construct($catalogProduct)
    {
        $this->categoriesTree = EavAttributeSetService::getCategoryTree($catalogProduct->attribute_set_name);
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('catalog::frontend.components.product-categories-component');
    }
}
