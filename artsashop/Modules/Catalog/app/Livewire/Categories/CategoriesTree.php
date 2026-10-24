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
