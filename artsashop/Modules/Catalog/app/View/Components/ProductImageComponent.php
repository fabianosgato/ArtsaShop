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

use App\Models\CatalogProduct;
use Idea\Framework\Repository\Catalog\CatalogProductMediaRepository;
use Illuminate\View\Component;
use Illuminate\View\View;

class ProductImageComponent extends Component
{
    public array $productImages;

    /**
     * Create a new component instance.
     */
    public function __construct(CatalogProduct $product)
    {
        // Retorna as imagens do produto
        $this->productImages = CatalogProductMediaRepository::getProductImagesData($product);
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('catalog::frontend.components.product-image-component');
    }

}
