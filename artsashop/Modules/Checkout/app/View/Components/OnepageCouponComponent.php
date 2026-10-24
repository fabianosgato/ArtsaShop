<?php

namespace Modules\Checkout\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\Checkout\Services\CheckoutCartService;

class OnepageCouponComponent extends Component
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
        return view('checkout::frontend.components.onepage-coupon-component');
    }
}
