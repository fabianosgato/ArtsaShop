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

namespace Feature\Idea\Repository;

use App\Models\CatalogProductBrand;
use Idea\Framework\Repository\Brand\CatalogProductBrandRepository;
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

    public function testUpdateOrCreate()
    {

    }

    public function testGetBrands()
    {

    }

    public function testUpdate()
    {

    }
}
