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
namespace Modules\Eav\Http\Controllers\Wsdadm;

use Idea\Framework\Admin\AdminController;
use Idea\Framework\Repository\Eav\EavAttributeSetRepository;
use Idea\Framework\Repository\Eav\EavAttributesRepository;
use Idea\Framework\Repository\Eav\EavEntityAttributeRepository;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class EavAttributesController extends AdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index(int $attributeSetId)
    {

        if ($attributeSetId) {

            $eavAttribute = EavAttributeSetRepository::getAttributeSetById(
                $attributeSetId
            );

            if ($eavAttribute) {
                View::share('actionInsert', route(
                    name: 'wsdadm.eav.attribute.insert',
                    parameters: [
                        'attributeSetId' => $eavAttribute->attribute_set_id
                    ]
                ));

                return view('eav::wsdadm.attribute.grid', [
                    'attributeSetId' => $eavAttribute->attribute_set_id,
                    'attributeSetName' => $eavAttribute->attribute_set_name,
                ]);

            }

        }

        Session::flash('error', 'O Grupo de atributo não foi localizado!');

        return redirect(route('wsdadm.eav.attributeset'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function insert($attributeSetId)
    {

        // Retorna a View
        return view('wsdadm.partials.forms', [
            'componentName' => 'eav::form.eav-attribute-form',
            'data' => [
                'attribute_set_id' => $attributeSetId
            ]
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($attributeSetId, $id)
    {

        // Retorna os dados do atributo
        $eavAttribute = EavAttributesRepository::getData()
            ->where(
                column: 'eav_attributes.attribute_id',
                operator: '=',
                value: $id
            )
            ->where(
                column: 'eav_entity_attribute.attribute_set_id',
                operator: '=',
                value: $attributeSetId
            );

        if ($eavAttribute->exists())

            // Retorna a View
            return view('wsdadm.partials.forms', [
                'componentName' => 'eav::form.eav-attribute-form',
                'data' => $eavAttribute->first()->toArray()
            ]);

        // Cria a mensagem
        Session::flash('error', "Atributo inexistente com o ID {$id}!");

        // Redireciona para listagem de produtos
        return redirect()->route('wsdadm.eav.attribute');

    }

    /**
     * Deleta a entidade do atributo.
     * @param $attributeSetId
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($attributeSetId, $id)
    {

        // Deleta o atributo referente ao grupo específico
        EavEntityAttributeRepository::deleteEntityAttribute(
            attributeSetId: $attributeSetId,
            attributeId:$id
        );

        // Cria a mensagem
        Session::flash('success', "Atributo Excluído com sucesso deste Grupo!");

        // Redireciona para listagem de produtos
        return redirect()->route('wsdadm.eav.attribute', [
            'attributeSetId' => $attributeSetId
        ]);

    }

}
