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
namespace Modules\Eav\Services;

use App\Models\EavAttribute;
use Idea\Framework\Repository\Catalog\CatalogProductAttributeRepository;
use Idea\Framework\Repository\Eav\EavAttributeSetRepository;
use Idea\Framework\Repository\Eav\EavAttributesRepository;
use Idea\Framework\Repository\Eav\EavEntityAttributeOptionRepository;
use Idea\Framework\Repository\Eav\EavEntityAttributeRepository;
use Illuminate\Support\Str;

class EavAttributeService
{

    /**
     * Insere/Atualiza os valores do atributo no sistema
     * @param \App\Models\EavAttribute $eavAttribute
     * @param int $attributeSetId
     * @param array $attributeData
     * @return void
     */
    protected static function saveEntityAttribute(EavAttribute $eavAttribute, int $attributeSetId, array $attributeData)
    {

        $eavEntityAttribute = EavEntityAttributeRepository::saveOrUpdate([
            'attribute_set_id' => $attributeSetId,
            'attribute_id' => $eavAttribute->attribute_id,
            'frontend_input' => $attributeData['frontend_input'],
            'sort_order' => $attributeData['sort_order'] ?? 0,
            'is_visible' => $attributeData['is_visible'] ?? false,
            'is_searchable' => $attributeData['is_searchable'] ?? false,
            'is_required' => $attributeData['is_required'] ?? false,
            'default_value' => $attributeData['default_value'] ?? null
        ]);

        if ($eavEntityAttribute) {

            // Valida os tipos do campo para inserir/atualizar as opções
            if (($attributeData['frontend_input'] == 'select') || ($attributeData['frontend_input'] == 'select-options')) {

                $eavEntityAttributeOptionData = [];

                foreach ($attributeData['options'] as $index => $option) {

                    $eavEntityAttributeOptionData[] = [
                        'eav_attribute_option_id' => $option['eav_attribute_option_id'] ?? null,
                        'attribute_set_id' => $attributeSetId,
                        'attribute_id' => $eavAttribute->attribute_id,
                        'entity_attribute_id' => $eavEntityAttribute->entity_attribute_id,
                        'option_name' => $option['option_name'],
                        'option_value' => $option['option_value'] ?? Str::slug($option['option_name'], '_'),
                        'sort_order' => ($index + 1) * 10,
                        'is_default' => $option['is_default'] ?? false,
                    ];

                }

                // Sincroniza os valores das opções do atributo
                EavEntityAttributeOptionRepository::sync(
                    entityAttributeId: $eavEntityAttribute->entity_attribute_id,
                    options: $eavEntityAttributeOptionData
                );


            }

        }

    }

    /**
     * Insere/Atualiza um grupo de atributos
     * @param $attributeData
     * @return \App\Models\EavAttribute|null
     */
    public static function saveOrUpdateAttributes($attributeData)
    {

        // Insere/Atualiza o atributo
        $eavAttribute = EavAttributesRepository::saveOrUpdate([
            'attribute_id' => $attributeData['attribute_id'] ?? null,
            'attribute_code' => $attributeData['attribute_code'],
            'attribute_label' => $attributeData['attribute_label'],
            'note' => Str::slug($attributeData['note'] ?? ''),
            'is_system' => $attributeData['is_system'],
            'is_global' => $attributeData['is_global'],
            'is_filterable' => $attributeData['is_filterable']
        ]);

        if ($eavAttribute) {

            if (!$attributeData['is_system']) {

                // Para atributos que não sao do sistema irá salvar apenas para o grupo específico
                self::saveEntityAttribute(
                    eavAttribute: $eavAttribute,
                    attributeSetId: $attributeData['attribute_set_id'],
                    attributeData: $attributeData
                );

            } else {

                // Para atributos que sao de sistema irá salvar em todos os grupos
                $attributeSets = EavAttributeSetRepository::getAttributeSets();

                foreach ($attributeSets as $attributeSet) {

                    // Para atributos que não sao do sistema irá salvar apenas para o grupo específico
                    self::saveEntityAttribute(
                        eavAttribute: $eavAttribute,
                        attributeSetId: $attributeSet->attribute_set_id,
                        attributeData: $attributeData
                    );

                }

            }

        }

        return $eavAttribute;


    }

    /**
     * Salva os atributos de um grupo de atributos
     * @param array $attributes
     * @param int $eavAttributeSetId
     * @return true
     */
    public static function saveAttributes(array $attributes, int $eavAttributeSetId)
    {

        foreach ($attributes as $idx => $attribute) {

            // Insere/Atualiza o atributo
            $eavAttribute = EavAttributesRepository::saveOrUpdate([
                'attribute_code' => $attribute['attributeCode'],
                'attribute_label' => $attribute['attributeName'],
                'frontend_input' => $attribute['frontendInput'],
                'url_key' => Str::slug($attribute['attributeName']),
                'default_value' => ''
            ]);

            // Valida se o atributo foi inserido/atualizado
            if ($eavAttribute)
                // Salva a relacao entre o Atributo e o Grupo de Atributos
                EavAttributesRepository::saveEavEntityAttribute([
                    'attributeSetId' => $eavAttributeSetId,
                    'attributeId' => $eavAttribute->attribute_id,
                    'frontendInput' => $attribute['frontendInput'],
                    'sortOrder' => $idx,
                    'isVisible' => $attribute['isVisible'],
                    'isSearchable' => $attribute['isSearchable'],
                    'isRequired' => $attribute['required'],
                    'defaultValue' => $attribute['valuesDefault'],
                    'values' => $attribute['values'],
                ]);

        }

        return true;

    }

    /**
     * Retorna o valor de um Atributo
     * @param int $productId
     * @param string $attributeCode
     * @return string
     */
    public static function getAttributeValue(int $productId, string $attributeCode): string
    {

        // Retorna o valor do atributo
        $attribute = CatalogProductAttributeRepository::getAttributeValue(
            productId:$productId,
            attributeCode:$attributeCode
        )->first()->toArray();

        if ($attribute) {
            if ($attribute['value'] != '') {
                return $attribute['value'];
            } else {
                return 'N/A';
            }
        }

        return 'N/A';

    }

    /**
     * Retorna uma lista de todos os atributos de um produto
     * @param int $productId
     * @return array
     */
    public static function getAttributes(int $productId): array
    {

        // Inicializa o array de atributos
        $attributes = [];

        // Seleciona todos os atributos de um produto
        $catalogAttributes = CatalogProductAttributeRepository::getAttributes($productId)
            ->get()
            ->toArray();

        foreach ($catalogAttributes as $catalogAttribute) {

            if ($catalogAttribute['frontend_input'] == 'text') {
                // Atributos com o valor "text"
                $attributes[] = [
                    'id' => $catalogAttribute['attribute_id'],
                    'code' => $catalogAttribute['attribute_code'],
                    'name' => $catalogAttribute['attribute_label'],
                    'value' => $catalogAttribute['value']
                ];

            } elseif ($catalogAttribute['frontend_input'] == 'boolean') {
                // Atributos com o valor "text"
                $attributes[] = [
                    'id' => $catalogAttribute['attribute_id'],
                    'code' => $catalogAttribute['attribute_code'],
                    'name' => $catalogAttribute['attribute_label'],
                    'value' => ($catalogAttribute['value'] ? "Sim" : 'Não')
                ];

            } elseif ($catalogAttribute['frontend_input'] == 'select') {

                $optionValue = EavEntityAttributeOptionRepository::getAtributeOptionValue(
                    entityAttributeId: $catalogAttribute['entity_attribute_id'],
                    attributeId: $catalogAttribute['attribute_id'],
                    value: $catalogAttribute['value']
                );

                // Atributos com o valor "text"
                $attributes[] = [
                    'id' => $catalogAttribute['attribute_id'],
                    'code' => $catalogAttribute['attribute_code'],
                    'name' => $catalogAttribute['attribute_label'],
                    'value' => $optionValue['option_name']
                ];
            }

        }

        return $attributes;

    }

}
