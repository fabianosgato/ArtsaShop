<?php

namespace Modules\Sales\View\Components\Frontend;

use Idea\Framework\Repository\Sales\SalesOrderAddressRepository;
use Illuminate\View\Component;
use Illuminate\View\View;

class DetailOrderAddressComponent extends Component
{

    public $address;

    /**
     * Create a new component instance.
     */
    public function __construct($orderId, $addressType = 'billing')
    {

        $this->address = SalesOrderAddressRepository::getAddress(
            orderId: $orderId,
            addressType:$addressType
        );

        if (!$this->address)
            $this->address = SalesOrderAddressRepository::getAddress(
                orderId: $orderId,
                addressType:'billing'
            );

    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('sales::components.frontend/detailorderaddresscomponent');
    }
}
