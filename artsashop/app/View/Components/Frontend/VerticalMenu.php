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

namespace App\View\Components\Frontend;

use Idea\Framework\Repository\Catalog\CatalogCategoryRepository;
use Illuminate\View\Component;

class VerticalMenu extends Component
{

    public $categories;

    protected $activeCategoryId;

    protected array $activePathIds = [];

    public function __construct($activeCategoryId = null)
    {
        $this->activeCategoryId = null;

        // Cache de Categorias
//        $this->categories = Cache::remember(
//            'catalog:categories:tree',
//            now()->addHours(24),
//            function () {
//                return CatalogCategoryRepository::getMenuCategories();
//            }
//        );

        $this->categories = CatalogCategoryRepository::getMenuCategories();

        // resolve slug atual
        $slug = trim(request()->path(), '/');

        if ($slug) {

            $this->activePathIds = $this->buildActivePathIdsFromTree(
                $this->categories,
                $slug
            );

            if (!empty($this->activePathIds)) {
                $this->activeCategoryId = end($this->activePathIds);
            }
        }

        if ($this->activeCategoryId) {
            $this->applyActiveState($this->categories);
        }
    }

    /**
     * 🔍 Busca caminho completo pelo slug (SEM DB)
     */
    protected function buildActivePathIdsFromTree(array $categories, string $slug, array $path = []): array
    {
        foreach ($categories as $category) {

            if (!$category['has_products']) {
                continue;
            }

            $newPath = [...$path, $category['entity_id']];

            if ($category['slug_key'] === $slug) {
                return $newPath;
            }

            if ($category['has_children']) {

                $found = $this->buildActivePathIdsFromTree(
                    $category['children'],
                    $slug,
                    $newPath
                );

                if ($found) {
                    return $found;
                }
            }
        }

        return [];
    }

    /**
     * 🔥 Aplica estado ativo (POR REFERÊNCIA)
     */
    protected function applyActiveState(array &$categories): void
    {
        foreach ($categories as &$category) {

            $category['is_active'] =
                $category['entity_id'] === $this->activeCategoryId;

            $category['is_open'] =
                in_array($category['entity_id'], $this->activePathIds);

            if ($category['has_children']) {
                $this->applyActiveState($category['children']);
            }
        }
    }

    public function render()
    {
        return view('frontend.components.catalog.navigation.mega-menu', [
            'categories' => $this->categories
        ]);
    }
}
