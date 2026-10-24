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
namespace Modules\Sales\Concerns;

use App\Models\SalesOrder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Sales\Transformers\SalesOrderResource;

trait OrdersApiResponse
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
            'data' => SalesOrderResource::collection($paginator->items()),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
        ];

    }

    protected function resultSalesOrder(SalesOrder $salesOrder): array
    {

        return [
            'request_info' => [
                'success' => true
            ],
            'request_metadata' => [
                'created_at' => date('Y-m-d H:i:s'),
                'processed_at' => date('Y-m-d H:i:s'),
            ],
            'data' => new SalesOrderResource($salesOrder),
        ];

    }

    protected function resultNone(): array
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
