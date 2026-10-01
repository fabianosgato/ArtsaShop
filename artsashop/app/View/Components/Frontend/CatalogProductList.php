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

use Illuminate\View\Component;

class CatalogProductList extends Component
{

    public string $title;
    public iterable $products;
    public ?string $link;

    public function __construct(
        string $title,
        iterable $products,
        ?string $link = null
    ) {
        $this->title = $title;
        $this->products = $products;
        $this->link = $link;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return view('frontend.components.catalog.product-lists');
    }

}
