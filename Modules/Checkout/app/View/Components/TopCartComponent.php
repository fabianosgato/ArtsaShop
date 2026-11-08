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
namespace Modules\Checkout\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\Checkout\Services\CheckoutCartService;

class TopCartComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        protected CheckoutCartService $cartService
    ) {}

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {

        return view('checkout::frontend.components.top-cart-component', [
            'cart' => $this->cartService->get()
        ]);

    }

}
