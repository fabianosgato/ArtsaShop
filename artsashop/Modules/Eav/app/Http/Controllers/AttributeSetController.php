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
namespace Modules\Eav\Http\Controllers;

use App\Models\EavAttributesSet;
use Exception;
use Idea\Framework\Admin\AdminController;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Repository\Eav\EavAttributesCategoryRepository;
use Idea\Framework\Repository\Eav\EavAttributeSetRepository;
use Idea\Framework\Repository\Eav\EavAttributesRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class AttributeSetController extends AdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('wsdadm.partials.grids', ['componentName' => 'eav::grids.eav-attributes-set-grid']);
    }

    /**
     * Metodo usado para buscar os Grupos de Atributos externamente
     * @param Request $request
     * @return array
     */
    public function ajax(Request $request): array
    {

        $resultSet = [];

        $query = EavAttributesSet::query();

        $query->addSelect([
            'eav_attributes_set.attribute_set_id',
            'eav_attributes_set.attribute_set_key',
            'eav_attributes_set.attribute_set_name'
        ]);

        $query->join(
            table:'eav_entity_attribute',
            first: 'eav_entity_attribute.attribute_set_id',
            operator: '=',
            second: 'eav_attributes_set.attribute_set_id'
        );

        $query->when(
            $request->search,
            fn (Builder $query) => $query
                ->where('attribute_set_name', 'like', "%{$request->search}%")
        );

        $attributeSets = $query->groupBy('eav_attributes_set.attribute_set_id')
            ->orderBy('attribute_set_name')
            ->get()
            ->toArray();

        foreach ($attributeSets as $idx => $attributeSetName){
            $resultSet[$attributeSetName['entity_id']] = "{$attributeSetName['attribute_set_name']}";
        }

        return $resultSet;

    }

    /**
     * Show the form for creating a new resource.
     */
    public function insert()
    {

        // Retorna a View
        return view('wsdadm.partials.forms', [
            'componentName' => 'eav::form.eav-attribute-set-form',
            'data' => []
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $eavAttributeSet = EavAttributeSetRepository::getAttributeSet($id);

        if ($eavAttributeSet) {

            // Retorna a View
            return view('wsdadm.partials.forms', [
                'componentName' => 'eav::form.eav-attribute-set-form',
                'data' => $eavAttributeSet
            ]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function delete($id)
    {

        // Retorna o grupo de atributo
        $eavAttributeSet = EavAttributeSetRepository::getAttributeSet($id);

        if ($eavAttributeSet) {

            EavAttributesCategoryRepository::deleteCategoryByAttributeSet(
                attributeSetId: $eavAttributeSet['attribute_set_id']
            );

            // Remove todos os produtos do grupo de atributo
            CatalogProductsRepository::deleteByAttributeSet(
                eavAttributeSetId:$eavAttributeSet['attribute_set_id']
            );

            // Remove o grupo de atributos
            EavAttributeSetRepository::delete($eavAttributeSet['attribute_set_id']);

            // Exclui o cache do menu do site
            Cache::delete('catalog:categories:tree');
            Cache::delete("catalog-category:category-by-attributett:attributeSetId:{$eavAttributeSet['attribute_set_id']}");

            Session::flash('success', "Grupo de Atributos: {$eavAttributeSet['attribute_set_name']} Excluído com Sucesso!");

            // Redireciona para o grid
            return redirect()->route('wsdadm.eav.attributeset');

        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request): RedirectResponse
    {

        // Retorna os dados do POST
        $postData = $request->post();

        if ($postData['_token']) {
            unset($postData['_token']);

            try {

                // Atualiza o grupo de atributos
                EavAttributeSetRepository::update(
                    id:$postData['attribute_set_id'],
                    attributes:$postData
                );

                Session::flash('success', 'Grupo de Atributos Atualizado com Sucesso!');

            } catch (Exception $e) {
                Session::flash('success', 'Erro ao atualizar o Grupo de Atributos : '.$e->getMessage());

            }

        }

        // Redireciona para o grid
        return redirect()->route('wsdadm.eav.attributeset');

    }

    public function attributes($id)
    {

        $eavAttributeSet = EavAttributesRepository::getAttributesBySetId($id)->get();

        dd($eavAttributeSet);

    }

}
