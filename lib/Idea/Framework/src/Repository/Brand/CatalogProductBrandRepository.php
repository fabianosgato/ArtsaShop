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

namespace Idea\Framework\Repository\Brand;

use App\Models\CatalogProductBrand;
use Idea\Framework\Repository\Brand\Contracts\CatalogProductBrandRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Facade estático para compatibilidade com código existente.
 * Delega para a instância resolvida via container (CatalogProductBrandRepositoryInterface).
 */
class CatalogProductBrandRepository
{
    private static function instance(): CatalogProductBrandRepositoryInterface
    {
        return app(CatalogProductBrandRepositoryInterface::class);
    }

    public static function getBrand(int $brandId): ?CatalogProductBrand
    {
        return self::instance()->getBrand($brandId);
    }

    public static function getBrands(int $perPage = 20): LengthAwarePaginator
    {
        return self::instance()->getBrands($perPage);
    }

    public static function getBrandByKey(string $brandKey): ?CatalogProductBrand
    {
        return self::instance()->getBrandByKey($brandKey);
    }

    public static function deleteBrand(int $brandId): void
    {
        self::instance()->deleteBrand($brandId);
    }

    public static function find(int $id): ?CatalogProductBrand
    {
        return self::instance()->find($id);
    }

    public static function updateOrCreate(array $attributes, array $values = [])
    {
        return self::instance()->updateOrCreate($attributes, $values);
    }
}
