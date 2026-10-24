<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 *
 * É concedida permissão, gratuitamente, a qualquer pessoa que obtenha uma cópia
 * deste software e arquivos de documentação associados
 *
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
