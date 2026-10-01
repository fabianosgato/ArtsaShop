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

namespace Modules\Catalog\Livewire\Categories;

use Idea\Framework\Repository\Catalog\CatalogCategoryRepository;
use Livewire\Component;

class CategoriesTree extends Component
{

    public function selectCategory(int $id)
    {
        $this->emitUp('categorySelected', $id);
    }

    public function render()
    {
        return view('catalog::wsdadm.livewire.categories.categories-tree', [
            'categories' => CatalogCategoryRepository::getTree(),
        ]);
    }
}
