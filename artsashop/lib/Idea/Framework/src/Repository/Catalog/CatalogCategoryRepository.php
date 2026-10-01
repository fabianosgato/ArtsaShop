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

use App\Models\CatalogCategoryEntity;
use Idea\Framework\Repository\AbstractRepository;
use Idea\Framework\Repository\System\SysUrlRewriteRepository;
use Illuminate\Support\Str;

class CatalogCategoryRepository extends AbstractRepository
{

    protected static $model = CatalogCategoryEntity::class;

    /**
     * Retorna todas as categorias do sistema
     * @return array
     */
    protected static function getAllCategories(): array
    {
        return self::loadModel()::query()
            ->select([
                'entity_id',
                'parent_id',
                'category'
            ])
            ->orderBy('category')
            ->get()
            ->toArray();
    }

    /**
     * Retorna as Categorias do Menu do siet
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getMenuCategories(int $level = 0, int $parentId = 0): array
    {

        $tree = [];

        // Busca categorias do nível atual
        $categories = self::getCategoriesTree(
            level: $level,
            parentId: $parentId
        );

        foreach ($categories as $category) {

            if ($level < 2) {

                // Busca filhos primeiro
                $children = self::getMenuCategories(
                    $level + 1,
                    $category['entity_id']
                );

                // Monta o nó
                $tree[] = [
                    'entity_id' => $category['entity_id'],
                    'parent_id' => $category['parent_id'],
                    'category' => $category['category'],
                    'slug_key' => $category['slug_key'],
                    'level' => $level,
                    'category_path' => $category['category_path'],
                    'is_open' => false,
                    'has_products' => true,
                    'has_children' => !empty($children),
                    'children' => $children,
                ];
            }
        }

        return $tree;
    }

    /**
     * Cria a slugKey a Categoria
     * @param \App\Models\CatalogCategoryEntity $category
     * @return string
     */
    public static function generateFullSlug(CatalogCategoryEntity $category): string
    {
        $segments = [];

        $current = $category;

        while ($current) {
            array_unshift($segments, Str::slug($current->category));
            $current = $current->parent;
        }

        return implode('/', $segments);

    }

    /**
     * Atualiza recursivamente o slug dos filhos
     */
    protected static function updateDescendantsSlug(int $parentId): void
    {
        $children = self::loadModel()::query()
            ->where('parent_id', $parentId)
            ->get();

        foreach ($children as $child) {

            // Recalcula slug baseado na nova estrutura
            $newSlug = self::generateFullSlug($child);

            $child->update([
                'slug_key' => $newSlug
            ]);

            // Insere/Atualiza o UrlReWrite
            SysUrlRewriteRepository::saveUrlRewrite([
                'request_path' => $newSlug,
                'target_path' => 'category/' . $child->entity_id,
                'target_type' => 'category',
                'is_system' => 1,
            ]);

            // Recursão para níveis abaixo
            self::updateDescendantsSlug($child->entity_id);

        }

    }

    /**
     * Insere/Atualiza uma categoria do sistema
     * @param $categoryData
     * @return \App\Models\CatalogCategoryEntity|null
     */
    public static function saveOrUpdate($categoryData): ?CatalogCategoryEntity
    {

        $updateCategory = null;

        if (!empty($categoryData['entity_id'])) {

            // Atualiza o Nome da Categoria
            $updateCategory = self::getData()->updateOrCreate(
                attributes: [
                    'entity_id' => $categoryData['entity_id']
                ],
                values: [
                    'category' => $categoryData['category']
                ]
            );

            if ($updateCategory) {

                // Atualiza slug da própria categoria
                $newSlug = self::generateFullSlug($updateCategory);

                $updateCategory->update([
                    'slug_key' => $newSlug
                ]);

                // Insere/Atualiza o UrlReWrite
                SysUrlRewriteRepository::saveUrlRewrite([
                    'request_path' => $newSlug,
                    'target_path' => 'category/' . $updateCategory->entity_id,
                    'target_type' => 'category',
                    'is_system' => 1,
                ]);

                // 🔥 Atualiza todos os filhos
                self::updateDescendantsSlug($updateCategory->entity_id);

            }

        } else {

            // Valida se o parentId veio na categoria
            if ($categoryData['parent_id']) {
                $updateCategory = self::getData()->firstOrCreate($categoryData);

            }

        }

        return $updateCategory;

    }

    /**
     * Insere uma Categproa da árvore de Categorias
     * @param array $categoryData
     * @return \App\Models\CatalogCategoryEntity|null
     */
    public static function saveCategoryTree(array $categoryData): ?CatalogCategoryEntity
    {

        // Retorna as informações da Categoria do sistema
        $catalogCategory = self::getCategoryByPath(
            categoryPath: $categoryData['category_path']
        );

        if (!$catalogCategory) {
            // Insere os dados da Categoria
            return self::loadModel()::query()->firstOrCreate($categoryData);
        } else {
            self::loadModel()::query()->find(
                id: $catalogCategory->entity_id
            )->update(
                ['category_path' => $categoryData['category_path']]
            );

            // Retorna as informações da Categoria do sistema
            return self::getCategoryByPath(
                categoryPath: $categoryData['category_path']
            );

        }

        return $catalogCategory;

    }

    /**
     * Valida se a categoria possui filhos
     * @param int $parentId
     * @return bool
     */
    public static function hasChildren(int $parentId): bool
    {
        return self::loadModel()::query()
            ->where('parent_id', $parentId)
            ->exists();
    }

    /**
     * Retorna a árvore de Categorias do sistema
     * @param $level
     * @param $parentId
     * @return array
     */
    public static function getCategoriesTree($level = 0, $parentId = 0): array
    {

        // Inicializa a Query
        $query = self::loadModel()::query();

        $query->select([
            'entity_id',
            'parent_id',
            'level',
            'slug_key',
            'category_path',
            'category'
        ]);

        $query->where(
            column: 'level',
            operator: '=',
            value: $level
        );

        $query->where(
            column: 'parent_id',
            operator: '=',
            value: $parentId
        );

        $query->orderBy('category');

        if ($query->get()) {
            return $query->get()->toArray();
        }

        return [];

    }    /**
     * Retorna a árvore de Categorias do sistema
     * @param $level
     * @param $parentId
     * @return array
     */
    public static function getCategoriesSearch($level = 0, $parentId = 0): array
    {

        // Inicializa a Query
        $query = self::loadModel()::query();

        $query->select([
            'entity_id',
            'parent_id',
            'level',
            'slug_key',
            'category_path',
            'category'
        ]);

        $query->where(
            column: 'parent_id',
            operator: '=',
            value: $parentId
        );

        $query->orderBy('category');

        if ($query->get()) {
            return $query->get()->toArray();
        }

        return [];

    }

    /**
     * Cria a arvore de categorias sem a necessidade de repetidas queries
     * @param array $items
     * @param int $parentId
     * @return array
     */
    protected static function buildTree(array $items, int $parentId = 0): array
    {
        $branch = [];

        foreach ($items as $item) {
            if ((int)$item['parent_id'] === $parentId) {

                $children = self::buildTree($items, (int)$item['entity_id']);

                $branch[] = [
                    'id' => (int)$item['entity_id'],
                    'name' => $item['category'],
                    'children' => $children,
                ];
            }
        }

        return $branch;
    }

    /**
     * Retorna a árvore de Categorias
     * @return array
     */
    public static function getTree(): array
    {
        $categories = self::getAllCategories();

        return self::buildTree($categories);
    }

    /**
     * Retorna a categoria pelo Slug
     * @param $slugKey
     * @return \App\Models\CatalogCategoryEntity|null
     */
    public static function getCategoryBySlug($slugKey): ?CatalogCategoryEntity
    {

        $catalogCategory = self::loadModel()::query()
            ->where(
                column: 'slug_key',
                operator: '=',
                value: $slugKey
            );

        if ($catalogCategory->exists())
            return $catalogCategory->first();

        return null;

    }

    /**
     * Retorna a categoria pelo Nome
     * @param $slugKey
     * @return \App\Models\CatalogCategoryEntity|null
     */
    public static function getCategoryByName($categoryName): ?CatalogCategoryEntity
    {

        $catalogCategory = self::loadModel()::query()
            ->where(
                column: 'category',
                operator: '=',
                value: $categoryName
            );

        if ($catalogCategory->exists())
            return $catalogCategory->first();

        return null;

    }

    /**
     * Retorna as categorias do sistema
     */
    public static function getCategoryByPath($categoryPath): ?CatalogCategoryEntity
    {

        // Busca a categoria
        $catalogCategory = self::loadModel()::query()
            ->where(
                column: 'category_path',
                operator: '=',
                value: $categoryPath
            );

        if ($catalogCategory->exists()) {
            return $catalogCategory->first();

        } else {
            $catalogCategory = self::loadModel()::query()
                ->where(
                    column: 'slug_key',
                    operator: '=',
                    value: $categoryPath
                );

            if ($catalogCategory->exists())
                return $catalogCategory->first();

        }

        return null;

    }

    /**
     * Retorna os dados de uma categoria pelo ID
     * @param int $categoryId
     * @return CatalogCategoryEntity|null
     */
    public static function getCategoryById(int $categoryId): ?CatalogCategoryEntity
    {

        $query = self::loadModel()::query()
            ->where(
                column: 'entity_id',
                operator: '=',
                value: $categoryId
            );

        if ($query->exists())
            return $query->first();

        return null;

    }

    /**
     * Retorna as categorias do sistema
     */
    public static function getCategoryByParentId($parentId): CatalogCategoryEntity
    {

        $query = self::loadModel()::query()
            ->where(
                column: 'entity_id',
                operator: '=',
                value: $parentId
            );

        return $query->get()->first();

    }

    /**
     * Retorna as categorias do sistema
     */
    public static function getCategoriesByParentId($parentId): \Illuminate\Database\Eloquent\Collection
    {

        $query = self::loadModel()::query()
            ->where(
                column: 'parent_id',
                operator: '=',
                value: $parentId
            );

        return $query->get();

    }

    /**
     * Retorna as informacoes do grupo de atributo relacionado a categoria
     * @param $categoryId
     * @return mixed|null
     */
    public static function getCategoryAttributeSet($categoryId)
    {

        // Inicializa a query
        $query = self::loadModel()::query();

        // Adiciona os campos
        $query->addSelect([
            'catalog_category_entity.category',
            'eav_attributes_set.attribute_set_key',
            'eav_attributes_set.product_qty'
        ]);

        # Join no Model EavAttributesCategory
        $query->join(
            table: 'eav_attributes_category',
            first: 'eav_attributes_category.eav_category_products_id',
            operator: '=',
            second: 'catalog_category_entity.entity_id'
        );

        # Join no Model EavAttributesCategory
        $query->join(
            table: 'eav_attributes_set',
            first: 'eav_attributes_set.attribute_set_id',
            operator: '=',
            second: 'eav_attributes_category.eav_attribute_set_id'
        );

        $query->where(
            column: 'catalog_category_entity.entity_id',
            operator: '=',
            value: $categoryId
        );

        if ($query->exists())
            return $query->first();

        return null;

    }

}
