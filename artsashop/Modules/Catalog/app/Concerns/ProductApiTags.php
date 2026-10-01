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
