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
declare(strict_types=1);

namespace Idea\Framework\Repository\Catalog;

use App\Models\CatalogProductAttribute;
use Idea\Framework\Repository\AbstractRepository;
use Idea\Framework\Repository\Eav\EavAttributesRepository;
use Idea\Framework\Repository\Eav\EavEntityAttributeRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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
     * @param int $productId
     * @param int $atributeSetId
     * @param string $attributeCode
     * @param mixed $value
     * @return void
     */
    public static function updateAttributes(int $productId, int $atributeSetId, string $attributeCode, $value): void
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
                    self::firstOrCreate(
                        attributes: [
                            'attribute_set_id' => $atributeSetId,
                            'attribute_id' => $eavAttribute->attribute_id,
                        ],
                        values: [
                            'product_id' => $productId,
                            'attribute_code' => $attributeCode,
                            'value' => $value,
                            'serialized_value' => json_encode($serializedValue)
                        ]
                    );

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
            value: $productId
        );

        $query->where(
            column: 'eav_attributes.attribute_id',
            operator: '=',
            value: $attributeId
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
        $query->where('catalog_product_attributes.product_id', '=', $productId);

        // Seleciona o attributo pelo código
        $query->where('eav_attributes.attribute_code', '=', $attributeCode);

        return $query;

    }

    /**
     * Atualiza/Insere múltiplos atributos de um produto em batch (elimina N+1)
     * @param int $productId
     * @param int $attributeSetId
     * @param array $attributes  Formato: [['code' => 'cor', 'value' => 'vermelho'], ['code' => 'tamanho', 'value' => ['M', 'G']], ...]
     * @return void
     */
    public static function updateAttributesBatch(int $productId, int $attributeSetId, array $attributes): void
    {
        if (empty($attributes)) {
            return;
        }

        // 1. Buscar todos os atributos EAV pelos códigos (1 query)
        $attributeCodes = array_column($attributes, 'code');
        $eavAttributes = EavAttribute::query()
            ->whereIn('attribute_code', $attributeCodes)
            ->get(['attribute_id', 'attribute_code'])
            ->keyBy('attribute_code');

        if ($eavAttributes->isEmpty()) {
            return;
        }

        $attributeIds = $eavAttributes->pluck('attribute_id')->all();

        // 2. Buscar configurações dos atributos no attribute set (1 query)
        $entityAttributes = \App\Models\EavEntityAttribute::query()
            ->whereIn('attribute_id', $attributeIds)
            ->where('attribute_set_id', '=', $attributeSetId)
            ->get(['entity_attribute_id', 'attribute_id', 'values', 'frontend_input'])
            ->keyBy('attribute_id');

        // 3. Buscar opções de select/multiselect se houver (1 query)
        $optionsByAttrId = [];
        $selectAttrIds = $entityAttributes->filter(fn($ea) => in_array($ea->frontend_input, ['select', 'multiselect']))->pluck('attribute_id')->all();
        if (!empty($selectAttrIds)) {
            $options = \App\Models\EavEntityAttributeOption::query()
                ->whereIn('attribute_id', $selectAttrIds)
                ->where('attribute_set_id', '=', $attributeSetId)
                ->get(['attribute_id', 'option_name', 'option_value'])
                ->groupBy('attribute_id');

            foreach ($options as $attrId => $opts) {
                $optionsByAttrId[$attrId] = $opts->mapWithKeys(fn($o) => [$o->option_name => $o->option_value])->all();
            }
        }

        // 4. Buscar valores atuais do produto (1 query)
        $existingAttrs = self::loadModel()::query()
            ->where('product_id', '=', $productId)
            ->whereIn('attribute_id', $attributeIds)
            ->get(['relacional_id', 'attribute_id', 'attribute_code', 'value', 'serialized_value'])
            ->keyBy('attribute_id');

        // 5. Preparar dados para upsert
        $upsertData = [];
        $now = now();

        foreach ($attributes as $attr) {
            $code = $attr['code'];
            $value = $attr['value'];

            $eavAttr = $eavAttributes->get($code);
            if (!$eavAttr) {
                continue; // Atributo não existe no sistema
            }

            $attrId = $eavAttr->attribute_id;
            $entityAttr = $entityAttributes->get($attrId);
            if (!$entityAttr) {
                continue; // Atributo não pertence a este attribute set
            }

            $serializedValue = [];

            // Processar valor para select/multiselect
            if (isset($optionsByAttrId[$attrId]) && $value !== null) {
                $attrOptions = $optionsByAttrId[$attrId];
                if (is_array($value)) {
                    foreach ($value as $val) {
                        if (isset($attrOptions[$val])) {
                            $serializedValue[] = $attrOptions[$val];
                        }
                    }
                } elseif (isset($attrOptions[$value])) {
                    $serializedValue[] = $attrOptions[$value];
                }
            }

            // Serializar value se for array
            $storedValue = is_array($value) ? json_encode($value) : $value;

            $existing = $existingAttrs->get($attrId);

            $row = [
                'product_id' => $productId,
                'attribute_set_id' => $attributeSetId,
                'attribute_id' => $attrId,
                'attribute_code' => $code,
                'value' => $storedValue,
                'serialized_value' => json_encode($serializedValue),
            ];

            if ($existing) {
                $row['relacional_id'] = $existing->relacional_id;
            }

            $upsertData[] = $row;
        }

        // 6. Bulk upsert (MySQL: INSERT ... ON DUPLICATE KEY UPDATE)
        if (!empty($upsertData)) {
            DB::table('catalog_product_attributes')->upsert(
                $upsertData,
                ['relacional_id'], // PK
                ['attribute_set_id', 'attribute_id', 'product_id', 'attribute_code', 'value', 'serialized_value']
            );
        }
    }

    /**
     * Retorna os atributos de um produto
     * @param int $productId
     * @return Builder
     */
    public static function getAttributes(int $productId): Builder
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

        $query->where('catalog_product_attributes.product_id', '=', $productId);

        $query->orderBy('eav_attributes.attribute_id');

        return $query;

    }

}