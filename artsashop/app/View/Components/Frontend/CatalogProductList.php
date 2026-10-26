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
