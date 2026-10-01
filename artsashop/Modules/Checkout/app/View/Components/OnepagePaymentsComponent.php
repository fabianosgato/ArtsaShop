<?php

namespace Modules\Checkout\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Modules\Payments\Providers\PaymentManager;

class OnepagePaymentsComponent extends Component
{
    public array $methods;

    public function __construct(
        public array $quote
    ) {

        $this->methods = app(PaymentManager::class)->all([
            'quote' => $this->quote,
            'customer' => auth()->user(),
        ]);

    }

    public function render(): View|string
    {
        return view('checkout::frontend.components.onepage-payments-component');
    }

}
