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

use App\Models\EavAttributesSet;
use Idea\Framework\Repository\Catalog\CatalogCategoryRepository;
use Idea\Framework\Repository\Eav\EavAttributesCategoryRepository;
use Idea\Framework\Repository\Eav\EavAttributeSetRepository;
use Idea\Framework\Repository\System\SysUrlRewriteRepository;
use Idea\Framework\Services\SeoPageService;
use Illuminate\Support\Str;

class EavAttributeSetService
{

    /**
     * Retorna os dados de Categoria pelo Grupo de Atributos
     * @param int $attributeSetId
     * @return array
     */
    public static function getData(int $attributeSetId): array
    {

        // Retorna as informacoes do atributo
        $attributeSet = EavAttributeSetRepository::getAttributeSetById($attributeSetId)
            ->first()
            ->toArray();

        if ($attributeSet) {
            return [
                'categoryId' => $attributeSet['eav_category_products_id'],
                'attributeSetId' => $attributeSet['attribute_set_id'],
                'attributeSetName' => $attributeSet['attribute_set_name'],
                'attributeSetKey' => $attributeSet['attribute_set_key'],
            ];
        }

        return [];

    }

    /**
     * Retorna a árvore de Categorias de um Grupo de Atributos do sistema
     * @param string $path
     * @param int $level
     * @param string|null $parentSlug
     * @param array $result
     * @return array
     */
    public static function getCategoryTree(string $path, int $level = 0, ?string $parentSlug = null, array &$result = []): array
    {

        $parts = explode('>', $path, 2);
        $category = trim($parts[0]);
        $isLast = count($parts) === 1;

        // Slug atual da categoria
        $currentSlug = Str::slug($category);

        // Slug completo (hierárquico)
        $slugKey = $parentSlug
            ? $parentSlug . '/' . $currentSlug
            : $currentSlug;

        $result[] = [
            'name' => $category,
            'url' => url($slugKey),
            'last' => $isLast,
        ];

        if (!$isLast) {
            self::getCategoryTree(
                path:$parts[1],
                level: $level + 1,
                parentSlug: $slugKey,
                result: $result
            );
        }

        return $result;

    }

    /**
     * Metodo responsavel por Criar a árvore de Categorias do sistema com base no Grupo de Atributos
     * @param int $eavAttributeSetId
     * @param string $path
     * @param int $level
     * @param int $parentId
     * @param array $result
     * @param string|null $parentSlug
     * @return void
     */
    public static function buildCategoryTree(int $eavAttributeSetId, string $path, int $level = 0, int $parentId = 0, array &$result = [], ?string $parentSlug = null): void
    {

        $parts = explode('>', $path, 2);

        $category = trim($parts[0]);
        $isLast = count($parts) === 1;

        // Slug atual da categoria
        $currentSlug = Str::slug($category);

        // Slug completo (hierárquico)
        $slugKey = $parentSlug
            ? $parentSlug . '/' . $currentSlug
            : $currentSlug;

        // Salva a categoria do sistema
        $saveCategory = CatalogCategoryRepository::saveCategoryTree([
            'parent_id' => $parentId,
            'category' => $category,
            'category_path' => $slugKey,
            'slug_key' => $slugKey,
            'level' => $level,
        ]);

        if ($saveCategory) {

            // Salva os dados do SEO da Categoria
            SeoPageService::saveSeoData(
                objectId: $saveCategory['entity_id'],
                object: 'category',
                seoPageData: [
                    'object' => 'category',
                    'object_id' => $saveCategory->entity_id,
                    'path' => $saveCategory->slug_key,
                    'title' => $saveCategory->category,
                    'title_source' => 'manual',
                    'description' => '',
                    'description_source' => 'manual',
                    'change_frequency' => 'weekly',
                    'priority' => 0.5,
                    'schema' => '',
                    'focus_keyword' => '',
                    'tags' => '',
                    'robot_index' => 'index',
                    'robot_follow' => 'follow',
                    'canonical_url' => url(trim($slugKey)),
                ]
            );

            // Salva os dados na SysUrlRewrite
            SysUrlRewriteRepository::saveUrlRewrite([
                'request_path' => $saveCategory->slug_key,
                'target_path' => 'category/' . $saveCategory->entity_id,
                'target_type' => 'category',
                'is_system' => 1,
            ]);

        }

        if (!$isLast) {
            self::buildCategoryTree(
                eavAttributeSetId: $eavAttributeSetId,
                path: $parts[1],
                level: $level + 1,
                parentId: $saveCategory['entity_id'],
                parentSlug: $slugKey
            );

        } else {
            EavAttributesCategoryRepository::saveRelationCategory(
                eavAttributeSetId: $eavAttributeSetId,
                eavCategoryProductId: $saveCategory['entity_id']
            );

        }

    }

    /**
     * Salva as informações do Grupo de Atributos
     * @param array $eavAttributeSetData
     * @return EavAttributesSet|false
     */
    public static function saveAttributeSet(array $eavAttributeSetData): ?EavAttributesSet
    {

        // Retorna o Grupo de Atributos pelo 'attributeSetKey'
        $eavAttributeSet = EavAttributeSetRepository::getAttributeSetByMlCategoryId(
            $eavAttributeSetData['attributeSetKey']
        );

        // Valida se existe na base
        if (!$eavAttributeSet) {
            // Cria o grupo de atributos
            $eavAttributeSet = EavAttributeSetRepository::create([
                'attribute_set_key' => $eavAttributeSetData['attributeSetKey'],
                'attribute_set_name' => $eavAttributeSetData['attributeSetName'],
                'stemming_words' => '',
                'is_category' => 0,
                'status' => true,
            ]);

        } else {
            // Atualiza o grupo de atributos
            EavAttributeSetRepository::updateAttributeSet(
                id: $eavAttributeSet->attribute_set_id,
                attributes: [
                    'attribute_set_key' => $eavAttributeSetData['attributeSetKey'],
                    'attribute_set_name' => $eavAttributeSetData['attributeSetName']
                ]
            );
        }

        if ($eavAttributeSet->is_category) {
            // Cria a arvore de categorias
            self::buildCategoryTree(
                eavAttributeSetId: $eavAttributeSet->attribute_set_id,
                path: $eavAttributeSet->attribute_set_name
            );
        }

        return $eavAttributeSet;

    }

}
