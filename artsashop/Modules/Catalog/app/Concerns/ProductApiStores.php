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

use Idea\Framework\Repository\Catalog\CatalogProductStoreRepository;
use Modules\System\Transformers\StoresResource;

trait ProductApiStores
{

    /**
     * Retorna as lojas do produto
     * @param $productId
     * @return array|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getProductStores($productId)
    {

        // Retorna as lojas que o produto pertence
        $stores = CatalogProductStoreRepository::getProductStores($productId);

        if ($stores)
            return StoresResource::collection($stores);

        return [];

    }

}
