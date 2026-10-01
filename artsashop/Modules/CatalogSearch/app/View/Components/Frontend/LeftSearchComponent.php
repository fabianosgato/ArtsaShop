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
use Idea\Framework\Repository\Catalog\CatalogProductPricesRepository;
use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\CatalogSearch\Services\SearchFiltersService;

class LeftSearchComponent extends Component
{

    /**
     * Cria uma instância do componente.
     */
    public function __construct(
        protected CatalogCategoryRepository $catalogCategoryRepository,
        protected SearchFiltersService      $searchFilterService
    )
    {
    }

    /**
     * Obtem a visualização/o conteúdo que representa o componente
     */
    public function render(): View|string
    {

        // Recupera o valor de 'category'
        $category = view()->shared('category');

        if ($category) {

            return view('catalogsearch::frontend.components.page-left-search-component', [
                'category' => $category->entity_id,
                'searchAction' => url($category->slug_key),
                'categories' => $this->catalogCategoryRepository::getCategoriesSearch(
                    level: $category->level,
                    parentId: $category->entity_id
                ),
                'prices' => $this->searchFilterService->buildPriceRanges(
                    priceRange: CatalogProductPricesRepository::getPriceRange(
                        categoryId:$category->entity_id
                    ),
                    steps: 16
                ),
            ]);

        } else {
            return view('catalogsearch::frontend.components.page-left-search-component', [
                'category' => null,
                'searchAction' => route('catalogsearch.result'),
                'categories' => [],
                'prices' => $this->searchFilterService->buildPriceRanges(
                    priceRange: CatalogProductPricesRepository::getPriceRange(null),
                    steps: 16
                ),
            ]);

        }


    }

}
