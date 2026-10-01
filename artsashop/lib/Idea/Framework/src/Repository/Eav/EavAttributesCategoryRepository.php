<?php

namespace Idea\Framework\Repository\Eav;

use App\Models\CatalogCategoryEntity;
use App\Models\EavAttributesCategory;
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Support\Facades\Cache;

class EavAttributesCategoryRepository extends AbstractRepository
{

    protected static $model = EavAttributesCategory::class;

    public static function saveRelationCategory($eavAttributeSetId, $eavCategoryProductId)
    {

        self::loadModel()::query()->firstOrCreate([
            'eav_attribute_set_id' => $eavAttributeSetId,
            'eav_category_products_id' => $eavCategoryProductId,
        ]);

    }

    /**
     * Retorna a categoria de um atributo especifico
     * @param $attributeSetId
     * @return null
     */
    public static function getCategoryByAttributeSet($attributeSetId)
    {

        // Inicializa a query
        $query = self::loadModel()::query();

        $query->join(
            table: 'catalog_category_entity',
            first: 'catalog_category_entity.entity_id',
            operator: '=',
            second: 'eav_attributes_category.eav_category_products_id'
        );

        $query->where(
            column: 'eav_attributes_category.eav_attribute_set_id',
            operator: '=',
            value:$attributeSetId
        );

        if ($query->exists())
            return $query->first();

        return null;

    }

    /**
     * Retorna a categoria de acordo com o Grupo de Atributos
     * @param $attributeSetId
     * @return mixed
     */
    public static function getCategoryByAttributeSetId($attributeSetId)
    {

        $cacheKey = "catalog-category:category-by-attributett:attributeSetId:{$attributeSetId}";

        return Cache::remember(
            $cacheKey,
            now()->addHours(6),
            function () use ($attributeSetId) {
                return self::getCategoryByAttributeSet(
                    $attributeSetId
                );
            }
        );

    }

    /**
     * Exclui uma categoria do sistema pelo ID do grupo de atributo
     * @param $attributeSetId
     * @return void
     */
    public static function deleteCategoryByAttributeSet($attributeSetId): void
    {

        $catalogCategory = self::getCategoryByAttributeSet(
            $attributeSetId
        );

        if ($catalogCategory) {
            $catalogCategoryEntity = CatalogCategoryEntity::query()->where(
                column: 'entity_id',
                operator: '=',
                value: $catalogCategory->entity_id
            );

            if ($catalogCategoryEntity->exists())
                $catalogCategoryEntity->delete();

        }

    }

}
