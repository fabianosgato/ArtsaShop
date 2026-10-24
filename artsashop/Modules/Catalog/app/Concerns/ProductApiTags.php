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

use Idea\Framework\Repository\Catalog\CatalogProductTagRepository;
use Modules\Catalog\Transformers\CatalogProductTagsResource;

trait ProductApiTags
{

    /**
     * Retorna as tags de um produto específico
     * @param int $productId
     */
    public function getProductTags(int $productId)
    {

        // Retorna as tags de produtos
        $tags = CatalogProductTagRepository::getTagsByProductId($productId);

        if ($tags != null)
            // Retorna as tags do sistema
            return CatalogProductTagsResource::collection($tags);

        return [];

    }

}
