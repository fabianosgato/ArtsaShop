<?php

namespace Modules\Catalog\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ProductPricesComponent extends Component
{

    public array $productPrices;

    /**
     * Create a new component instance.
     */
    public function __construct($product)
    {

        $this->productPrices = [
            'price_id' => $product['price_id'],
            'price' => $product['price'],
            'final_price' => $product['final_price'],
            'price_discount' => $product['price'] - ($product['price'] * (10 / 100))
        ];

    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('catalog::frontend.components.product-prices-component');
    }
}
