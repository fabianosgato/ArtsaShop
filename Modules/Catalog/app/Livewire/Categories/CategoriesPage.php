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
