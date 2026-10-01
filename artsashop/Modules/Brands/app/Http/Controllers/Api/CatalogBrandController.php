<?php

namespace Modules\Brands\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Idea\Framework\Concerns\PaginatesApiResponse;
use Idea\Framework\Concerns\ResultApiResponse;
use Idea\Framework\Repository\Brand\CatalogProductBrandRepository;
use Illuminate\Http\Request;
use Modules\Brands\Services\CatalogProductBrandService;

class CatalogBrandController extends Controller
{

    use PaginatesApiResponse;
    use ResultApiResponse;

    /**
     * Lista todas as Marcas do sistema
     */
    public function index(Request $request)
    {

        // Retorna os itens por página
        $perPage = $request->get('per_page', 20);

        // Retorna as Marcas do sistema
        $brands = CatalogProductBrandRepository::getBrands($perPage);

        // Response Json
        return response()->json(
            $this->paginatedResponse($brands)
        );

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Valida o nome e a key da Marca
        if ($request->get('brandName') && $request->get('brandKey')) {

            $catalogProductBrand = CatalogProductBrandService::saveBrands([
                'brandName' => $request->get('brandName'),
                'brandKey' => $request->get('brandKey'),
                'brandUrl' => $request->get('brandUrl'),
            ]);

            if ($catalogProductBrand) {

                return response()->json([
                    'request_info' => [
                        'success' => true
                    ],
                    'request_metadata' => [
                        'created_at' => date('Y-m-d H:i:s'),
                        'processed_at' => date('Y-m-d H:i:s'),
                    ],
                    'data' => $this->response($catalogProductBrand),
                ]);

            }

        }

        return response()->json([
            'request_info' => [
                'success' => false
            ],
            'request_metadata' => [
                'created_at' => date('Y-m-d H:i:s'),
                'processed_at' => date('Y-m-d H:i:s'),
            ],
            'data' => []
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $key)
    {

        // Valida o nome e a key da Marca
        if ($request->get('brandName') && $request->get('brandKey')) {

            $catalogProductBrand = CatalogProductBrandService::saveBrands([
                'brandName' => $request->get('brandName'),
                'brandKey' => $request->get('brandKey'),
                'brandUrl' => $request->get('brandUrl'),
            ]);

            if ($catalogProductBrand) {

                return response()->json(
                    $this->response($catalogProductBrand)
                );

            }

        }

        return response()->json([
            'error' => true,
            'message' => 'Dados Vazios'
        ]);

    }

}
