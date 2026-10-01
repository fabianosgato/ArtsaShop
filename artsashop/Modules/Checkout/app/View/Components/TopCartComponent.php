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
