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
namespace Modules\CatalogSearch\View\Components\Frontend;

use Idea\Framework\Repository\Catalog\CatalogCategoryRepository;
use Illuminate\View\Component;
use Illuminate\View\View;

class HomeSearchComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct() {
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        // CatalogSearch/resources/views/frontend/components/home-search-component.blade.php
        return view('catalogsearch::frontend.components.home-search-component', [
            'categories' => CatalogCategoryRepository::getCategoriesTree(
                level: 1,
                parentId: 1
            )
        ]);
    }
}
