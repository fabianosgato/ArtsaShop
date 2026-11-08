<?php

namespace Modules\Catalog\View\Components\Frontend;

use App\Models\CatalogProduct;
use Illuminate\View\Component;
use Illuminate\View\View;

class ProductItemWishlistComponent extends Component
{

    public CatalogProduct $product;

    /**
     * Create a new component instance.
     */
    public function __construct($catalogProduct)
    {
        $this->product = $catalogProduct;
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('catalog::frontend.components.product-item-wishlist-component');
    }

}
