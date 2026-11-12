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

use App\Models\CatalogProduct;
use Modules\Catalog\Transformers\CatalogProductResource;

trait ProductsApiResponse
{

    protected function resultCatalogProduct(CatalogProduct $catalogProduct)
    {

        return [
            'request_info' => [
                'success' => true
            ],
            'request_metadata' => [
                'created_at' => date('Y-m-d H:i:s'),
                'processed_at' => date('Y-m-d H:i:s'),
            ],
            'data' => new CatalogProductResource($catalogProduct),
        ];

    }

    protected function resultNone()
    {

        return [
            'request_info' => [
                'success' => true
            ],
            'request_metadata' => [
                'created_at' => date('Y-m-d H:i:s'),
                'processed_at' => date('Y-m-d H:i:s'),
            ],
            'data' => [],
        ];

    }

    protected function resultError(): array
    {

        return [
            'request_info' => [
                'success' => false
            ],
            'request_metadata' => [
                'created_at' => date('Y-m-d H:i:s'),
                'processed_at' => date('Y-m-d H:i:s'),
            ],
            'data' => []
        ];

    }
    protected function resultErrorEmpty($data): array
    {

        return [
            'request_info' => [
                'success' => false
            ],
            'request_metadata' => [
                'created_at' => date('Y-m-d H:i:s'),
                'processed_at' => date('Y-m-d H:i:s'),
            ],
            'data' => $data
        ];

    }

}
