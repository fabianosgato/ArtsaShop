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

use Livewire\Attributes\On;
use Livewire\Component;

class CategoriesPage extends Component
{

    public ?int $categoryId = null;

    protected $listeners = [
        'categorySelected' => 'setCategory',
    ];

    #[On('category-selected')]
    public function setCategory(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function render()
    {
        return view('catalog::wsdadm.livewire.categories.categories-page');
    }
}
