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
namespace Modules\Catalog\Concerns;

use Idea\Framework\Repository\Catalog\CatalogProductMediaRepository;
use Modules\Catalog\Transformers\CatalogProductImagesResource;

trait ProductApiImages
{

    public function getProductImages(int $productId)
    {

        // Retorna as imagens do produto
        $images = CatalogProductMediaRepository::getProductImages($productId);

        if ($images)
            return CatalogProductImagesResource::collection($images);

        return null;

    }

}
