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

namespace Idea\Framework\Repository\Catalog;

use App\Models\CatalogProductAttribute;
use Idea\Framework\Repository\AbstractRepository;
use Idea\Framework\Repository\Eav\EavAttributesRepository;
use Idea\Framework\Repository\Eav\EavEntityAttributeRepository;
use Illuminate\Database\Eloquent\Builder;

class CatalogProductAttributeRepository extends AbstractRepository
{

    protected static $model = CatalogProductAttribute::class;

    protected static function getIdByName(array $items, $name): ?array
    {
        foreach ($items as $item) {
            if ($item['name'] === $name) {
                return $item;
            }
        }
        return null;
    }

    /**
     * Atualiza/Insere os atributos de um produto
     * @param $productId
     * @param $attributeCode
     * @param $value
     * @return void
     */
    public static function updateAttributes($productId, $atributeSetId, $attributeCode, $value)
    {

        // Retorna os dados do atributo
        $eavAttribute = EavAttributesRepository::getAttributeByCode($attributeCode);

        if ($eavAttribute) {

            // Retorna as opçoes do atributo cadastrado
            $eavEntityAttributeOption = EavEntityAttributeRepository::getAttributeValues(
                attributeId: $eavAttribute->attribute_id,
                attributeSetId: $atributeSetId
            );

            if ($eavEntityAttributeOption) {

                $serializedValue = [];

                if ($eavEntityAttributeOption['values'] != '') {

                    // Decodifica as opcoes do atributo
                    $attributeValues = json_decode($eavEntityAttributeOption['values'], true);

                    // Valida se o valor é um array
                    if (($attributeValues != null) and (!is_null($value))) {
                        if (count($attributeValues) > 0) {
                            // Retorna o valor do atributo
                            if (!is_array($value)) {
                                $serializedValue = self::getIdByName($attributeValues, $value);
                            } else {
                                // Valida quando um valor de um atributo for um array
                                foreach ($value as $val) {
                                    $serializedValue[] = self::getIdByName($attributeValues, $val);
                                }
                            }
                        }
                    }

                }

                # Verifica se os valores sao um array
                if (is_array($value))
                    $value = json_encode($value);

                // Retorna o valor atual do atributo no produto
                $attributeValue = self::loadModel()::query()
                    ->where('catalog_product_attributes.attribute_id', '=', $eavAttribute->attribute_id)
                    ->where('catalog_product_attributes.product_id', '=', $productId);

                if ($attributeValue->exists()) {
                    // Atualiza o valor do atributo já existente
                    self::loadModel()::query()->where(['relacional_id' => $attributeValue->first()->relacional_id])
                        ->update([
                            'attribute_code' => $attributeCode,
                            'value' => $value,
                            'serialized_value' => json_encode($serializedValue)
                        ]);
                } else {
                    // Cria o novo atributo do produto
                    self::create([
                        'attribute_set_id' => $atributeSetId,
                        'attribute_id' => $eavAttribute->attribute_id,
                        'product_id' => $productId,
                        'attribute_code' => $attributeCode,
                        'value' => $value,
                        'serialized_value' => json_encode($serializedValue)
                    ]);

                }

            }

        }

    }

    /**
     * Retorna os dados para o formulario de cadastro do produto
     * @param int $productId
     * @param int $attributeId
     * @return string
     */
    public static function getAttributeFormValue(int $productId, int $attributeId): string
    {

        // Inicializa a query
        $query = self::loadModel()::query();

        $query->addSelect([
            'eav_attributes.attribute_code',
            'catalog_product_attributes.relacional_id',
            'catalog_product_attributes.value'
        ]);

        // Join na tabela de EavAttributes
        $query->join(
            table:'eav_attributes',
            first:'eav_attributes.attribute_id',
            operator:'=',
            second:'catalog_product_attributes.attribute_id'
        );

        $query->where(
            column: 'catalog_product_attributes.product_id',
            operator: '=',
            value:$productId
        );

        $query->where(
            column: 'eav_attributes.attribute_id',
            operator: '=',
            value:$attributeId
        );

        if ($query->exists()) {

            $attributeValues = $query->first();

            if ($attributeValues) {
                $attribute = $attributeValues->toArray();

                return "{$attribute['value']}";

            }

        }

        return '';

    }

    /**
     * Retorna o valor de um atributo
     * @param int $productId
     * @param string $attributeCode
     * @return Builder
     */
    public static function getAttributeValue(int $productId, string $attributeCode): Builder
    {

        // Inicializa a Query
        $query = self::loadModel()::query();

        $query->addSelect([
            'eav_attributes.attribute_id',
            'eav_attributes.attribute_code',
            'eav_attributes.attribute_label',
            'catalog_product_attributes.value',
        ]);

        $query->join(
            table: 'eav_attributes',
            first: 'eav_attributes.attribute_id',
            operator:'=',
            second:'catalog_product_attributes.attribute_id'
        );

        // Seleciona o atributo pelo Produto
        $query->where('catalog_product_attributes.product_id', $productId);

        // Seleciona o attributo pelo código
        $query->where('eav_attributes.attribute_code', $attributeCode);

        return $query;

    }

    /**
     * Retorna os atributos de um produto
     * @param $productId
     * @return Builder
     */
    public static function getAttributes($productId): Builder
    {

        // Inicializa a Query
        $query = self::loadModel()::query();

        $query->addSelect([
            'eav_attributes.attribute_id',
            'eav_attributes.attribute_code',
            'eav_attributes.attribute_label',
            'catalog_product_attributes.value',
        ]);

        $query->join(
            table: 'eav_attributes',
            first: 'eav_attributes.attribute_id',
            operator:'=',
            second:'catalog_product_attributes.attribute_id'
        );

        $query->where('catalog_product_attributes.product_id', $productId);

        $query->orderBy('eav_attributes.attribute_id');

        return $query;

    }

}
