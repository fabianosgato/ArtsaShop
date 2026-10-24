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
namespace Modules\System\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Idea\Framework\Repository\System\SysStoreRepository;
use Modules\System\Transformers\StoresResource;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {

        return response()->json([
            'request_info' => [
                'success' => true
            ],
            'request_parameters' => [],
            'request_metadata' => [
                'created_at' => date('Y-m-d H:i:s'),
                'processed_at' => date('Y-m-d H:i:s'),
            ],
            'data' => StoresResource::collection(SysStoreRepository::getStores())
        ]);

    }


}
