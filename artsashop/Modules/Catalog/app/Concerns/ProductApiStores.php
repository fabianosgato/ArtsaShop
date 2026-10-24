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
