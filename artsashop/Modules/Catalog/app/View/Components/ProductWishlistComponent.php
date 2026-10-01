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

namespace Modules\Catalog\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ProductWishlistComponent extends Component
{

    public $productId;

    /**
     * Create a new component instance.
     */
    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {

//        // Valida se o cliente esta realmente autenticado
//        if (Auth::guard('customer')->check()) {
//
//            // Retorna as informações do Customer pelo ID
//            $customer = Auth::guard('customer')->user();
//
//            $wishlist = CustomerWishlistEntityRepository::checkIsWishlist(
//                customerId: $customer->customer_id,
//                productId: $this->productId
//            );
//
//            if ($wishlist)
//                return view('catalog::frontend.components.product-wishlist-component', [
//                    'icon' => 'fa-solid fa-heart'
//                ]);
//
//        }

        return view('catalog::frontend.components.product-wishlist-component', [
            'icon' => 'fa-regular fa-heart'
        ]);

    }

}
