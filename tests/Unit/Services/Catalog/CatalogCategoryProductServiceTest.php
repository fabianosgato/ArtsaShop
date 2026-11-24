<?php

namespace Tests\Unit\Services\Catalog;

use Modules\Catalog\DTO\CategoryDto;
use Modules\Catalog\Services\CatalogCategoryProductService;
use PHPUnit\Framework\TestCase;

class CatalogCategoryProductServiceTest extends TestCase
{
    protected function getService(): CatalogCategoryProductService
    {
        return new CatalogCategoryProductService;
    }

    /** @return CategoryDto[] */
    protected function makeCategories(array $data): array
    {
        return array_map(CategoryDto::fromArray(...), $data);
    }

    /** @test */
    public function test_build_active_path_ids_from_tree_finds_correct_path(): void
    {
        $service = $this->getService();

        $categories = $this->makeCategories([
            [
                'entityId' => 1,
                'parentId' => 0,
                'category' => 'Eletrônicos',
                'slugKey' => 'eletronicos',
                'level' => 0,
                'categoryPath' => 'eletronicos',
                'isOpen' => false,
                'hasProducts' => true,
                'hasChildren' => true,
                'children' => [
                    [
                        'entityId' => 2,
                        'parentId' => 1,
                        'category' => 'Celulares',
                        'slugKey' => 'eletronicos/celulares',
                        'level' => 1,
                        'categoryPath' => 'eletronicos/celulares',
                        'isOpen' => false,
                        'hasProducts' => true,
                        'hasChildren' => false,
                        'children' => [],
                    ],
                    [
                        'entityId' => 3,
                        'parentId' => 1,
                        'category' => 'Notebooks',
                        'slugKey' => 'eletronicos/notebooks',
                        'level' => 1,
                        'categoryPath' => 'eletronicos/notebooks',
                        'isOpen' => false,
                        'hasProducts' => true,
                        'hasChildren' => true,
                        'children' => [
                            [
                                'entityId' => 4,
                                'parentId' => 3,
                                'category' => 'Gaming',
                                'slugKey' => 'eletronicos/notebooks/gaming',
                                'level' => 2,
                                'categoryPath' => 'eletronicos/notebooks/gaming',
                                'isOpen' => false,
                                'hasProducts' => true,
                                'hasChildren' => false,
                                'children' => [],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $result = $service->buildActivePathIdsFromTree($categories, 'eletronicos/notebooks/gaming');

        $this->assertEquals([1, 3, 4], $result);
    }

    /** @test */
    public function test_build_active_path_ids_from_tree_returns_empty_when_not_found(): void
    {
        $service = $this->getService();

        $categories = $this->makeCategories([
            [
                'entityId' => 1,
                'parentId' => 0,
                'category' => 'Eletrônicos',
                'slugKey' => 'eletronicos',
                'level' => 0,
                'categoryPath' => 'eletronicos',
                'isOpen' => false,
                'hasProducts' => true,
                'hasChildren' => false,
                'children' => [],
            ],
        ]);

        $result = $service->buildActivePathIdsFromTree($categories, 'inexistente');

        $this->assertEquals([], $result);
    }

    /** @test */
    public function test_build_active_path_ids_from_tree_skips_categories_without_products(): void
    {
        $service = $this->getService();

        $categories = $this->makeCategories([
            [
                'entityId' => 1,
                'parentId' => 0,
                'category' => 'Eletrônicos',
                'slugKey' => 'eletronicos',
                'level' => 0,
                'categoryPath' => 'eletronicos',
                'isOpen' => false,
                'hasProducts' => false, // Sem produtos - deve pular
                'hasChildren' => true,
                'children' => [
                    [
                        'entityId' => 2,
                        'parentId' => 1,
                        'category' => 'Celulares',
                        'slugKey' => 'eletronicos/celulares',
                        'level' => 1,
                        'categoryPath' => 'eletronicos/celulares',
                        'isOpen' => false,
                        'hasProducts' => true,
                        'hasChildren' => false,
                        'children' => [],
                    ],
                ],
            ],
        ]);

        $result = $service->buildActivePathIdsFromTree($categories, 'eletronicos/celulares');

        // Como o pai não tem produtos, ele pula e não encontra o caminho
        $this->assertEquals([], $result);
    }

    /** @test */
    public function test_apply_active_state_marks_active_and_open(): void
    {
        $service = $this->getService();

        $categories = $this->makeCategories([
            [
                'entityId' => 1,
                'parentId' => 0,
                'category' => 'Eletrônicos',
                'slugKey' => 'eletronicos',
                'level' => 0,
                'categoryPath' => 'eletronicos',
                'isOpen' => false,
                'hasProducts' => true,
                'hasChildren' => true,
                'children' => [
                    [
                        'entityId' => 2,
                        'parentId' => 1,
                        'category' => 'Celulares',
                        'slugKey' => 'eletronicos/celulares',
                        'level' => 1,
                        'categoryPath' => 'eletronicos/celulares',
                        'isOpen' => false,
                        'hasProducts' => true,
                        'hasChildren' => false,
                        'children' => [],
                    ],
                ],
            ],
        ]);

        // applyActiveState agora retorna nova árvore (imutável)
        $updated = $service->applyActiveState($categories, 2, [1, 2]);

        // Verificar categoria pai (aberta pois está no path)
        $this->assertTrue($updated[0]->isOpen);
        $this->assertFalse($updated[0]->isActive);

        // Verificar filho (ativo e aberto)
        $this->assertTrue($updated[0]->children[0]->isActive);
        $this->assertTrue($updated[0]->children[0]->isOpen);
    }

    /** @test */
    public function test_apply_active_state_does_not_mark_inactive_branches(): void
    {
        $service = $this->getService();

        $categories = $this->makeCategories([
            [
                'entityId' => 1,
                'parentId' => 0,
                'category' => 'Eletrônicos',
                'slugKey' => 'eletronicos',
                'level' => 0,
                'categoryPath' => 'eletronicos',
                'isOpen' => false,
                'hasProducts' => true,
                'hasChildren' => true,
                'children' => [
                    [
                        'entityId' => 2,
                        'parentId' => 1,
                        'category' => 'Celulares',
                        'slugKey' => 'eletronicos/celulares',
                        'level' => 1,
                        'categoryPath' => 'eletronicos/celulares',
                        'isOpen' => false,
                        'hasProducts' => true,
                        'hasChildren' => false,
                        'children' => [],
                    ],
                    [
                        'entityId' => 3,
                        'parentId' => 1,
                        'category' => 'Notebooks',
                        'slugKey' => 'eletronicos/notebooks',
                        'level' => 1,
                        'categoryPath' => 'eletronicos/notebooks',
                        'isOpen' => false,
                        'hasProducts' => true,
                        'hasChildren' => false,
                        'children' => [],
                    ],
                ],
            ],
        ]);

        // Ativo é o ID 2 (celulares), path [1, 2]
        $updated = $service->applyActiveState($categories, 2, [1, 2]);

        // Pai está no path -> is_open
        $this->assertTrue($updated[0]->isOpen);
        $this->assertFalse($updated[0]->isActive);

        // Celulares é ativo -> is_active e is_open
        $this->assertTrue($updated[0]->children[0]->isActive);
        $this->assertTrue($updated[0]->children[0]->isOpen);

        // Notebooks NÃO está no path -> nem active nem open
        $this->assertFalse($updated[0]->children[1]->isActive);
        $this->assertFalse($updated[0]->children[1]->isOpen);
    }
}
