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
declare(strict_types=1);

namespace Idea\Framework\Repository\Eav;

use App\Models\EavAttribute;
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Support\Str;

class EavAttributesRepository extends AbstractRepository
{

    protected static $model = EavAttribute::class;

    public static function getData(): \Illuminate\Database\Eloquent\Builder
    {

        $query = self::loadModel()->query();

        $query->select([
            'eav_attributes.attribute_id',
            'eav_entity_attribute.entity_attribute_id',
            'eav_entity_attribute.attribute_set_id',

            'eav_attributes.attribute_code',
            'eav_attributes.attribute_label',
            'eav_attributes.note',
            'eav_attributes.is_system',
            'eav_attributes.is_global',
            'eav_attributes.is_filterable',

            'eav_entity_attribute.frontend_input',
            'eav_entity_attribute.sort_order',
            'eav_entity_attribute.is_visible',
            'eav_entity_attribute.is_searchable',
            'eav_entity_attribute.is_required',
            'eav_entity_attribute.default_value',
            'eav_entity_attribute.values'
        ])
        ->join(
            table: 'eav_entity_attribute',
            first: 'eav_entity_attribute.attribute_id',
            operator: '=',
            second: 'eav_attributes.attribute_id'
        );

        return $query;

    }

    /**
     * Insere/Atualiza um atributo no sistema
     * @param array $attributeData
     * @return \App\Models\EavAttribute|null
     */
    public static function saveOrUpdate(array $attributeData): ?EavAttribute
    {

        // Busca pelo atributo
        $attribute = self::getData()->where(
            column: 'attribute_code',
            operator: '=',
            value: $attributeData['attribute_code']
        );

        if ($attribute->exists()) {

            // Atualiza as informações do Atributo e retorna os dados
            return self::loadModel()::query()->updateOrCreate(
                attributes: [
                    'attribute_id' => $attribute->first()->attribute_id,
                    'attribute_code' => $attributeData['attribute_code']
                ],
                values:[
                    'attribute_label' => $attributeData['attribute_label'],
                    'slug_key' => Str::slug($attributeData['attribute_label']),
                    'note' => $attributeData['note'],
                    'is_system' => $attributeData['is_system'],
                    'is_global' => $attributeData['is_global'],
                    'is_filterable' => $attributeData['is_filterable']
                ]
            );

        } else {

            // Cria o atributo na base de dados
            return self::loadModel()::query()->firstOrCreate(
                [
                    'attribute_code' => $attributeData['attribute_code']
                ],
                [
                    'attribute_label' => $attributeData['attribute_label'],
                    'frontend_input' => $attributeData['frontend_input'],
                    'slug_key' => Str::slug($attributeData['attribute_label']),
                    'note' => '',
                    'is_system' => false,
                    'is_global' => false,
                    'is_filterable' => false
                ]
            );

        }

    }

    /**
     * Salva a relacao do atributo com o seu respectivo grupo de atributos.
     * @param array $attributeData
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public static function saveEavEntityAttribute(array $attributeData): \Illuminate\Database\Eloquent\Model|false
    {

        $eavEntityAttribute = EavEntityAttributeRepository::saveOrUpdate([
            'attribute_set_id' => $attributeData['attributeSetId'],
            'attribute_id' => $attributeData['attributeId'],
            'frontend_input' => $attributeData['frontendInput'],
            'sort_order' => $attributeData['sortOrder'],
            'is_visible' => $attributeData['isVisible'],
            'is_searchable' => $attributeData['isSearchable'],
            'is_required' => $attributeData['isRequired'],
            'default_value' => $attributeData['defaultValue'],
            'values' => json_encode($attributeData['values']),
        ]);

        if ($eavEntityAttribute) {

            if (!empty($attributeData['values'])) {

                if (count($attributeData['values']) > 0) {

                    foreach ($attributeData['values'] as $option) {

                        // Valida se o valor passado possui padrão
                        if (!empty($attributeData['defaultValue'])) {
                            $defaultValue = json_decode($attributeData['defaultValue'], true);
                            if ($defaultValue['name'] == $option['name']) {
                                $isDefault = true;
                            } else {
                                $isDefault = false;
                            }
                        } else {
                            $isDefault = false;
                        }

                        EavEntityAttributeOptionRepository::saveOrUpdate([
                            'attribute_set_id' => $attributeData['attributeSetId'],
                            'attribute_id' => $attributeData['attributeId'],
                            'entity_attribute_id' => $eavEntityAttribute->entity_attribute_id,
                            'option_id' => $option['id'],
                            'option_name' => $option['name'],
                            'is_default' => $isDefault
                        ]);

                    }
                }
            }

            return $eavEntityAttribute;

        }

        return false;

    }

    /**
     * Retorna um atributo pelo código
     * @param $attributeCode
     * @return \App\Models\EavAttribute|null
     */
    public static function getAttributeByCode($attributeCode)
    {
        return EavAttribute::query()
            ->where('attribute_code', '=', $attributeCode)
            ->first();
    }

    /**
     * Retorna um array com os atributos de um grupo específico
     * @param $attributeSetId
     * @param bool $isVisible
     * @return \Illuminate\Database\Eloquent\Builder|null
     */
    public static function getAttributesBySetId($attributeSetId, bool $isVisible = true): ?\Illuminate\Database\Eloquent\Builder
    {

        $eavAttribute = self::getData();

        $eavAttribute->where(
            column: 'eav_entity_attribute.attribute_set_id',
            operator: '=',
            value: $attributeSetId
        );

        if ($isVisible)
            $eavAttribute->where(
                column: 'eav_entity_attribute.is_visible',
                operator: '=',
                value: true
            );

        $eavAttribute->orderBy('eav_entity_attribute.sort_order');

        if ($eavAttribute->exists())
            return $eavAttribute;

        return null;

    }


}
