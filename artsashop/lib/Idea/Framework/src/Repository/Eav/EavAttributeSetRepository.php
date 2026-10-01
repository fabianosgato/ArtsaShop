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

use App\Models\CatalogProduct;
use App\Models\EavAttributesSet;
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class EavAttributeSetRepository extends AbstractRepository
{

    protected static $model = EavAttributesSet::class;

    /**
     * Retorna o ID de um grupo de atributos padrão
     * @return null
     */
    public static function getDefaultAttributeId()
    {

        $query = self::getData()->addSelect([
            'eav_attributes_set.attribute_set_id',
            'eav_attributes_set.attribute_set_key',
            'eav_attributes_set.attribute_set_name'
        ])->join(
            table: 'eav_entity_attribute',
            first: 'eav_entity_attribute.attribute_set_id',
            operator: '=',
            second: 'eav_attributes_set.attribute_set_id'
        )->where(
            column: 'eav_attributes_set.is_default',
            operator: '=',
            value: true
        );

        if ($query->exists())
            return $query->first()->attribute_set_id;

        return null;


    }

    /**
     * Exclui o grupo de atributos do sistema
     * @param int $id
     * @return int
     */
    public static function delete(int $id): int
    {
        return self::loadModel()::query()->where(['attribute_set_id' => $id])->delete();
    }

    /**
     * Retorna um array para gerar as opçoes nos Grids e Forms
     * @param string $search
     * @return array
     */
    public static function getOptionsData(string $search = ''): array
    {

        $resultSet = [];

        $query = self::getData();

        $query->addSelect([
            'eav_attributes_set.attribute_set_id',
            'eav_attributes_set.attribute_set_key',
            'eav_attributes_set.attribute_set_name'
        ]);

        $query->join(
            table: 'eav_entity_attribute',
            first: 'eav_entity_attribute.attribute_set_id',
            operator: '=',
            second: 'eav_attributes_set.attribute_set_id'
        );

        $query->when(
            $search,
            fn(Builder $query) => $query
                ->where('attribute_set_name', 'like', "%{$search}%")
        );

        $attributeSets = $query->groupBy('eav_attributes_set.attribute_set_id')
            ->orderBy('attribute_set_name')
            ->get()
            ->toArray();

        foreach ($attributeSets as $attributeSetName) {
            $resultSet[$attributeSetName['attribute_set_id']] = "{$attributeSetName['attribute_set_name']}";
        }

        return $resultSet;
    }

    /**
     * Metodo que retorna o atributo pelo ML ID com as informacoes de Categoria
     * @param $attributeSetKey
     * @return \App\Models\EavAttributesSet|null
     */
    public static function getAttributeSetByMlCategoryId($attributeSetKey): ?EavAttributesSet
    {

        // Inicializa a query
        $eavAttributeSet = self::getData()
            ->where(
                column: 'attribute_set_key',
                operator: '=',
                value: $attributeSetKey
            );

        if ($eavAttributeSet->exists())
            return $eavAttributeSet->first();

        return null;

    }

    /**
     * Metodo que retorna o atributo pelo ID com as informacoes de Categoria
     * @param int $attributeSetId
     * @return \App\Models\EavAttributesSet|null
     */
    public static function getAttributeSetById(int $attributeSetId): ?EavAttributesSet
    {

        // Inicializa a query
        $eavAttributeSet = self::loadModel()::query();

        $eavAttributeSet->addSelect([
            'eav_attributes_set.attribute_set_id',
            'eav_attributes_set.attribute_set_name',
            'eav_attributes_set.attribute_set_key',
            'eav_attributes_category.eav_category_products_id',
        ]);

        $eavAttributeSet->join(
            table: 'eav_attributes_category',
            first: 'eav_attributes_category.eav_attribute_set_id',
            operator: '=',
            second: 'eav_attributes_set.attribute_set_id'
        );

        // Retorna pelo ID
        $eavAttributeSet->where(
            column: 'attribute_set_id',
            operator: '=',
            value: $attributeSetId
        );

        if ($eavAttributeSet->exists())
            // Retorna o Atributo
            return $eavAttributeSet->first();

        return null;

    }

    /**
     * Retorna o Grupo de Atributos pelo ID
     * @param int $attributeSetId
     * @return mixed[]
     */
    public static function getAttributeSet(int $attributeSetId): array
    {

        // Retorna os dados do grupo de atributos
        return self::loadModel()::query()->find($attributeSetId)->toArray();

    }

    /**
     * Metodo que retorna um array com os grupos de atributos usado para filtros
     * @param bool $withAttributes
     * @return array
     */
    public static function getAttibuteSetOptions(bool $withAttributes = true): array
    {

        // Inicializa a variavel
        $optionsData = [];

        $query = self::getData();

        $query->addSelect([
            'eav_attributes_set.attribute_set_id',
            'eav_attributes_set.attribute_set_name'
        ]);

        // Por padrao retorna apenas os grupos de atributos que possuem atributos
        if ($withAttributes) {

            $query->join(
                table: 'eav_entity_attribute',
                first: 'eav_entity_attribute.attribute_set_id',
                operator: '=',
                second: 'eav_attributes_set.attribute_set_id'
            );

            $query->groupBy('eav_attributes_set.attribute_set_id');

        }

        // Ordena pelo Nome do atributo
        $query->orderBy('eav_attributes_set.attribute_set_name');

        // Retorna o array com os dados
        $attributeSets = $query->get()->toArray();

        foreach ($attributeSets as $attributeSet) {
            $optionsData[$attributeSet['attribute_set_id']] = $attributeSet['attribute_set_name'];
        }

        return $optionsData;

    }

    /**
     * Retorna os grupos de atributos com as suas respctivas categorias
     * @return Builder
     */
    public static function getAttributesSetWithCategory(): Builder
    {

        // Inicializa a query
        $query = self::getData();

        $query->addSelect([
            'catalog_category_entity.entity_id as categoryId',
            'eav_attributes_set.attribute_set_id as attributeSetId',
            'eav_attributes_set.attribute_set_name as attributeSetName',
            'eav_attributes_set.attribute_set_key as mlcategoryId',
        ]);

        $query->join(
            table: 'eav_attributes_category',
            first: 'eav_attributes_category.eav_attribute_set_id',
            operator: '=',
            second: 'eav_attributes_set.attribute_set_id'
        );

        $query->join(
            table: 'catalog_category_entity',
            first: 'catalog_category_entity.entity_id',
            operator: '=',
            second: 'eav_attributes_category.eav_category_products_id'
        );

        $query->orderBy('eav_attributes_set.attribute_set_name');

        return $query;

    }

    /**
     * Metodo usado para listar as marcas com Paginação
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getAttributeSets(int $perPage = 20): LengthAwarePaginator
    {

        $query = self::getData()
            ->addSelect([
                'eav_attributes_set.attribute_set_id',
                'eav_attributes_set.attribute_set_key',
                'eav_attributes_set.attribute_set_name'
            ])
            ->orderBy('eav_attributes_set.attribute_set_name');

        return $query->paginate($perPage);

    }

    /**
     * Metodo usado para atualizar o grupo de atributos do sistema
     * @param int|null $id
     * @param array $attributes
     * @return \App\Models\EavAttributesSet|null
     */
    public static function updateAttributeSet(?int $id, array $attributes = []): ?EavAttributesSet
    {

        try {

            if (!$id) {
                // Cria a key do atributo
                $attributes['attribute_set_key'] = app('currentStore')->code_order."-".Str::uuid7();
            }

            return self::getData()->updateOrCreate(
                attributes: [
                    'attribute_set_id' => $id
                ],
                values: $attributes
            );

        } catch (\Exception $e) {
            return null;

        }

    }

    /**
     * Processa todos os Produtos dos Grupos de Atributos o configurando ao Marketplace
     * @param int $attributeSetId
     * @param bool $addToQueue
     * @return void
     */
    public static function updateAllProducts(int $attributeSetId, bool $addToQueue = true): void
    {

        // Retorna o grupo de atributos
        $attributeSet = EavAttributesSet::query()->find($attributeSetId);

        // Retorna TODOS os produtos do grupo de atributos
        $catalogProducts = CatalogProduct::query()
            ->where('attribute_set_id', '=', $attributeSetId)
            ->get()
            ->toArray();

//        foreach ($catalogProducts as $catalogProduct) {
//
//            // Adiciona os produtos à fila de atualizacao
//            if ($addToQueue)
//                CatalogProductService::addToQueue($catalogProduct);
//
//        }

    }


}
