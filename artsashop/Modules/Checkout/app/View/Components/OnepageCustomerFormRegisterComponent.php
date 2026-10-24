<?php

namespace Modules\Checkout\View\Components;

use Idea\Framework\Repository\System\SysAddressStateRepository;
use Illuminate\View\Component;
use Illuminate\View\View;

class OnepageCustomerFormRegisterComponent extends Component
{

    public $quote;

    public $regions;

    /**
     * Create a new component instance.
     */
    public function __construct($quote) {

        // Variável do quote do pedido
        $this->quote = $quote;

        // Repositorio de Regioes (estados do brasil)
        $this->regions = SysAddressStateRepository::loadModel()::query()->get();

    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('checkout::frontend.components.customer.customer-form-register');
    }

}
