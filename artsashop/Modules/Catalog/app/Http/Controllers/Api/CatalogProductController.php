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
namespace Modules\Catalog\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Illuminate\Http\Request;
use Modules\Catalog\Concerns\ProductsApiResponse;
use Modules\Catalog\Services\CatalogProductService;

class CatalogProductController extends Controller
{

    use ProductsApiResponse;

    /**
     * Lista todos os produtos do sistema
     */
    public function index(Request $request)
    {

        if ($request->accepts(['application/json'])) {

            // Retorna os itens por página
            $perPage = $request->get('per_page', 20);

            // Retorna as Marcas do sistema
            $catalogProducts = CatalogProductsRepository::getProductsPagination($perPage);

            // Response Json
            return response()->json(
                $this->paginatedResponse($catalogProducts)
            );

        }

        return response()->json(
            $this->resultError()
        );

    }

    /**
     * Insere um produto.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {

        if ($request->accepts(['application/json'])) {

            // Array data vindos da API
            $arrayData = $request->all();

            if ($arrayData) {

                foreach ($arrayData['skus'] as $skus) {

                    if (!empty($skus['productSku'])) {

                        // Realiza as validações do produto
                        $catalogProduct = CatalogProductService::saveOrUpdate(
                            productSku: $skus['productSku'],
                            payload: json_decode($request->getContent(), true)
                        );

                        return response()->json(
                            $this->resultCatalogProduct($catalogProduct)
                        );

                    }

                }

            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Dados enviados sao incorretos ',
                ]);
            }
        }

        return response()->json([
            'error' => true,
            'message' => 'Dados Vazios',
        ]);

    }

    /**
     * Atualzia um produto.
     */
    public function update(Request $request)
    {
        $arrayData = $request->json()->all();

        if (empty($arrayData)) {
            return response()->json(
                $this->resultErrorEmpty('Dados Vazios'),
                400
            );
        }

        foreach ($arrayData['skus'] ?? [] as $skus) {
            if (!empty($skus['productSku'])) {
                $catalogProduct = CatalogProductService::saveOrUpdate(
                    productSku: $skus['productSku'],
                    payload: $arrayData
                );

                if ($catalogProduct)
                    return response()->json(
                        $this->resultCatalogProduct($catalogProduct)
                    );
                else
                    return response()->json($this->resultNone());
            }
        }

        return response()->json(
            $this->resultErrorEmpty('SKU não informado'),
            422
        );

    }

    /**
     * Exibe as informações de um produto
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {

        if ($request->accepts(['application/json'])) {

            if ($request->get('productSku')) {

                // Retorna o produto pelo SKU
                $catalogProduct = CatalogProductsRepository::getProductBySku(
                    productSku:$request->get('productSku')
                );

                if ($catalogProduct != null)
                    return response()->json(
                        $this->resultCatalogProduct(
                            catalogProduct: $catalogProduct
                        )
                    );
                else
                    return response()->json($this->resultNone());

            }

        }

        return response()->json($this->resultError());


    }

}
