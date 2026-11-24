<?php

namespace Tests\Unit\Services\Catalog;

use Modules\Catalog\Services\CatalogCategoryProductService;
use PHPUnit\Framework\TestCase;

class CatalogCategoryProductServiceTest extends TestCase
{
    protected function getService(): CatalogCategoryProductService
    {
        return new CatalogCategoryProductService();
    }

    /** @test */
    public function testBuildActivePathIdsFromTreeFindsCorrectPath(): void
    {
        $service = $this->getService();
        
        $categories = [
            [
                'entity_id' => 1,
                'slug_key' => 'eletronicos',
                'has_products' => true,
                'has_children' => true,
                'children' => [
                    [
                        'entity_id' => 2,
                        'slug_key' => 'eletronicos/celulares',
                        'has_products' => true,
                        'has_children' => false,
                        'children' => [],
                    ],
                    [
                        'entity_id' => 3,
                        'slug_key' => 'eletronicos/notebooks',
                        'has_products' => true,
                        'has_children' => true,
                        'children' => [
                            [
                                'entity_id' => 4,
                                'slug_key' => 'eletronicos/notebooks/gaming',
                                'has_products' => true,
                                'has_children' => false,
                                'children' => [],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $result = $service->buildActivePathIdsFromTree($categories, 'eletronicos/notebooks/gaming');
        
        $this->assertEquals([1, 3, 4], $result);
    }

    /** @test */
    public function testBuildActivePathIdsFromTreeReturnsEmptyWhenNotFound(): void
    {
        $service = $this->getService();
        
        $categories = [
            [
                'entity_id' => 1,
                'slug_key' => 'eletronicos',
                'has_products' => true,
                'has_children' => false,
                'children' => [],
            ],
        ];

        $result = $service->buildActivePathIdsFromTree($categories, 'inexistente');
        
        $this->assertEquals([], $result);
    }

    /** @test */
    public function testBuildActivePathIdsFromTreeSkipsCategoriesWithoutProducts(): void
    {
        $service = $this->getService();
        
        $categories = [
            [
                'entity_id' => 1,
                'slug_key' => 'eletronicos',
                'has_products' => false, // Sem produtos - deve pular
                'has_children' => true,
                'children' => [
                    [
                        'entity_id' => 2,
                        'slug_key' => 'eletronicos/celulares',
                        'has_products' => true,
                        'has_children' => false,
                        'children' => [],
                    ],
                ],
            ],
        ];

        $result = $service->buildActivePathIdsFromTree($categories, 'eletronicos/celulares');
        
        // Como o pai não tem produtos, ele pula e não encontra o caminho
        $this->assertEquals([], $result);
    }

    /** @test */
    public function testApplyActiveStateMarksActiveAndOpen(): void
    {
        $service = $this->getService();
        
        $categories = [
            [
                'entity_id' => 1,
                'slug_key' => 'eletronicos',
                'has_products' => true,
                'has_children' => true,
                'children' => [
                    [
                        'entity_id' => 2,
                        'slug_key' => 'eletronicos/celulares',
                        'has_products' => true,
                        'has_children' => false,
                        'children' => [],
                    ],
                ],
            ],
        ];

        $service->applyActiveState($categories, 2, [1, 2]);

        // Verificar categoria pai (aberta pois está no path)
        $this->assertTrue($categories[0]['is_open']);
        $this->assertFalse($categories[0]['is_active']);

        // Verificar filho (ativo e aberto)
        $this->assertTrue($categories[0]['children'][0]['is_active']);
        $this->assertTrue($categories[0]['children'][0]['is_open']);
    }

    /** @test */
    public function testApplyActiveStateDoesNotMarkInactiveBranches(): void
    {
        $service = $this->getService();
        
        $categories = [
            [
                'entity_id' => 1,
                'slug_key' => 'eletronicos',
                'has_products' => true,
                'has_children' => true,
                'children' => [
                    [
                        'entity_id' => 2,
                        'slug_key' => 'eletronicos/celulares',
                        'has_products' => true,
                        'has_children' => false,
                        'children' => [],
                    ],
                    [
                        'entity_id' => 3,
                        'slug_key' => 'eletronicos/notebooks',
                        'has_products' => true,
                        'has_children' => false,
                        'children' => [],
                    ],
                ],
            ],
        ];

        // Ativo é o ID 2 (celulares), path [1, 2]
        $service->applyActiveState($categories, 2, [1, 2]);

        // Pai está no path -> is_open
        $this->assertTrue($categories[0]['is_open']);
        $this->assertFalse($categories[0]['is_active']);

        // Celulares é ativo -> is_active e is_open
        $this->assertTrue($categories[0]['children'][0]['is_active']);
        $this->assertTrue($categories[0]['children'][0]['is_open']);

        // Notebooks NÃO está no path -> nem active nem open
        $this->assertFalse($categories[0]['children'][1]['is_active']);
        $this->assertFalse($categories[0]['children'][1]['is_open']);
    }
}
