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
namespace Modules\CatalogSearch\View\Components\Frontend;

use Idea\Framework\Repository\Catalog\CatalogCategoryRepository;
use Illuminate\View\Component;
use Illuminate\View\View;

class FilterSearchComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct() {}

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('catalogsearch::frontend.components.filter-search-component', [
            'categories' => CatalogCategoryRepository::getCategoriesTree(
                level: 1,
                parentId: 1
            )
        ]);
    }
}
