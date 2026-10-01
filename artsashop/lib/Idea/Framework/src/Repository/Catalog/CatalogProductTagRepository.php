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

use App\Models\CatalogProductTag;
use App\Models\CatalogProductTagsEntity;
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Support\Str;

class CatalogProductTagRepository extends AbstractRepository
{

    protected static $model = CatalogProductTag::class;

    public static function getOptions(): array
    {
        return self::loadModel()::query()
            ->orderBy('tag_name')
            ->pluck('tag_name', 'tag_id')
            ->toArray();
    }

    public static function getTagsByProductId(int $productId)
    {

        $tags = self::loadModel()::query()
            ->select(['tag_name', 'slug_key'])
            ->join(
                table: 'catalog_product_tags_entity',
                first: 'catalog_product_tags_entity.tag_id',
                operator: '=',
                second: 'catalog_product_tags.tag_id'
            )
            ->where(
                column: 'catalog_product_tags_entity.product_id',
                operator: '=',
                value: $productId
            );

        if ($tags->exists())
            return $tags->get();

        return null;

    }

    /**
     * Cria a tag de produtos
     * @param string $name
     * @return \App\Models\CatalogProductTag
     */
    public static function firstOrCreateByName(string $name): CatalogProductTag
    {

        // Verifica se a tag exsite
        $catalogProductTag = self::getData()->where(
            column: 'slug_key',
            operator: '=',
            value: Str::slug($name)
        );

        // Se nao existir, cria a tag
        if (!$catalogProductTag->exists()) {
            return self::loadModel()::query()->firstOrCreate([
                'slug_key' => Str::slug($name),
            ], [
                'slug_key' => Str::slug($name),
                'tag_name' => $name,
            ]);

        }

        return $catalogProductTag->first();

    }

    public static function saveTagToProduct($productId, $tagName)
    {

        // Cria e Retorna as informações da Tag
        $catalogProductTag = self::firstOrCreateByName($tagName);

        if ($catalogProductTag)

            // Cria a relacao do produto com a tag
            CatalogProductTagsEntity::query()->firstOrCreate([
                'product_id' => $productId,
                'tag_id' => $catalogProductTag->tag_id
            ]);


    }


}
