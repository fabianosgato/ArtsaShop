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

use App\Models\CatalogProduct;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Catalog\Transformers\CatalogProductResource;

trait ProductsApiResponse
{

    /**
     * Paginação de produtos
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator
     * @return array
     */
    protected function paginatedResponse(LengthAwarePaginator $paginator): array
    {

        return [
            'request_info' => [
                'success' => true
            ],
            'request_metadata' => [
                'created_at' => date('Y-m-d H:i:s'),
                'processed_at' => date('Y-m-d H:i:s'),
            ],
            'data' => CatalogProductResource::collection($paginator->items()),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
        ];

    }

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
