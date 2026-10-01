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
namespace Modules\Eav\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Idea\Framework\Concerns\PaginatesApiResponse;
use Idea\Framework\Concerns\ResultApiResponse;
use Idea\Framework\Repository\Eav\EavAttributeSetRepository;
use Illuminate\Http\Request;
use Modules\Eav\Services\EavAttributeService;
use Modules\Eav\Services\EavAttributeSetService;
use Modules\Eav\Transformers\EavAttributeSetResource;

class AttributeSetController extends Controller
{

    use PaginatesApiResponse;
    use ResultApiResponse;

    /**
     * Retorna os grupos e atributos cadastrados no sistema.
     */
    public function index(Request $request)
    {
        // Retorna os itens por página
        $perPage = $request->get('per_page', 20);

        // Retorna as Marcas do sistema
        $resultData = EavAttributeSetRepository::getPaginationAttributeSets($perPage);

        // Response Json
        return response()->json(
            $this->paginatedResponse($resultData)
        );

    }

    /**
     * Action que cria o grupo de atributos com seus respectivos atributos
     */
    public function store(Request $request)
    {

        if ($request->accepts(['application/json'])) {

            // Array data vindos da API
            $arrayData = $request->all();

            if ($arrayData) {

                // Salva as informações do grupo de atributos
                $eavAttributeSet = EavAttributeSetService::saveAttributeSet($arrayData);

                // Valida se o grupo de atributos foi salvo com sucesso
                if ($eavAttributeSet) {

                    // Salva os atributos do Grupo de Atributos
                    $eavAttributes = EavAttributeService::saveAttributes(
                        attributes: $arrayData['attributes'],
                        eavAttributeSetId: $eavAttributeSet['attribute_set_id']
                    );

                    if ($eavAttributes)
                        return new EavAttributeSetResource($eavAttributeSet);

                }

            } else {
                $this->error('Dados Inválidos');

            }
        }

        return $this->error('Dados Vazios');

    }

    /**
     * Action que atualiza o grupo de atributos com seus respectivos atributos
     */
    public function update(Request $request)
    {

        if ($request->accepts(['application/json'])) {

            // Array data vindos da API
            $arrayData = $request->all();

            if ($arrayData) {

                // Salva as informações do grupo de atributos
                $eavAttributeSet = EavAttributeSetService::saveAttributeSet($arrayData);

                if ($eavAttributeSet) {

                    // Salva os atributos do Grupo de Atributos
                    $eavAttributes = EavAttributeService::saveAttributes(
                        attributes: $arrayData['attributes'],
                        eavAttributeSetId: $eavAttributeSet['attribute_set_id']
                    );

                    if ($eavAttributes)
                        return new EavAttributeSetResource($eavAttributeSet);
                }

            } else {
                $this->error('Dados Inválidos');

            }
        }

        return $this->error('Dados Vazios');
    }

    /**
     * Show the specified resource.
     */
    public function show($attributeSetKey)
    {

        if ($attributeSetKey) {

            $eavAttributeSet = EavAttributeSetRepository::getAttributeSetByMlCategoryId(
                $attributeSetKey
            );

            if ($eavAttributeSet) {
                return new EavAttributeSetResource($eavAttributeSet);
            } else {
                $this->error('Dados Inválidos');

            }

        }

        return $this->error('Dados Vazios');

    }

}
