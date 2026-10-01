<?php

namespace Modules\Checkout\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\Checkout\Services\CheckoutCartService;

class OnepageReviewComponent extends Component
{

    public $quote;

    /**
     * Create a new component instance.
     */
    public function __construct($quote) {
        $this->quote = $quote;
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('checkout::frontend.components.onepage-review-component', [
            'cart' => app(CheckoutCartService::class)->get()
        ]);
    }
}
