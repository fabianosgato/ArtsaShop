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

namespace Tests\Feature\Idea\Repository;

use App\Models\CatalogProductBrand;
use Idea\Framework\Repository\Brand\CatalogProductBrandRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class CatalogProductBrandRepositoryTest extends TestCase
{

    public function testGetBrand()
    {

        $catalogProductBrand = CatalogProductBrandRepository::getBrand(12989);

        $this->assertInstanceOf(
            CatalogProductBrand::class,
            $catalogProductBrand
        );

        $this->assertEquals(
            12989,
            $catalogProductBrand->brand_id
        );

    }

    public function testGetBrandReturnsNullWhenBrandDoesNotExist(): void
    {
        $catalogProductBrand = CatalogProductBrandRepository::getBrand(999999);
        $this->assertNull($catalogProductBrand);
    }

    public function testGetBrandByKey()
    {

        $catalogProductBrand = CatalogProductBrandRepository::getBrandByKey(
            brandKey: 'koolababy'
        );

        $this->assertInstanceOf(
            CatalogProductBrand::class,
            $catalogProductBrand
        );

        $this->assertEquals(
            'koolababy',
            $catalogProductBrand->brand_key
        );

    }

    public function testUpdateOrCreateWhenBrandExists()
    {

        $catalogProductBrand = CatalogProductBrandRepository::updateOrCreate(
            id:12973,
            values:[
                'brand_key' => 'koolababy',
                'brand_name' => 'KoolaBaby',
                'page_title' => 'Koolababy Products',
                'content' => 'Koolababy Products is Where!!!!',
                'brand_url' => 'catalog/koolababy',
                'is_salable' => true
            ]
        );

        $this->assertInstanceOf(
            CatalogProductBrand::class,
            $catalogProductBrand
        );

        $this->assertEquals(
            'koolababy',
            $catalogProductBrand->brand_key
        );

    }

    public function testUpdateOrCreateWhenBrandNotExists()
    {

        $catalogProductBrand = CatalogProductBrandRepository::updateOrCreate(
            id:null,
            values:[
                'brand_key' => \Illuminate\Support\Str::slug('Xing Ling Products'),
                'brand_name' => 'Xing Ling Products',
                'page_title' => 'Xing Ling Products',
                'content' => 'Xing Ling Products Products is Where!!!!',
                'brand_url' => \Illuminate\Support\Str::slug('Xing Ling Products'),
                'is_salable' => true
            ]
        );

        $this->assertInstanceOf(
            CatalogProductBrand::class,
            $catalogProductBrand
        );

        $this->assertEquals(
            'Xing Ling Products',
            $catalogProductBrand->brand_name
        );

    }

    public function testGetBrands()
    {

        $catalogProductBrand = CatalogProductBrandRepository::getBrands(
            20
        );

        $this->assertInstanceOf(
            LengthAwarePaginator::class,
            $catalogProductBrand
        );

        $this->assertEquals(
            20,
            $catalogProductBrand->perPage()
        );

    }

}
