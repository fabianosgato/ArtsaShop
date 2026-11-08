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
