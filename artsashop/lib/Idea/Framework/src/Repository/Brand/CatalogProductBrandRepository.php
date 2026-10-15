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
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CatalogProductBrandRepository extends AbstractRepository
{

    // Inicializa o Model
    protected static $model = CatalogProductBrand::class;

    /**
     * Retorna uma marca pelo Id
     * @param $brandId
     * @return \App\Models\CatalogProductBrand|null
     */
    public static function getBrand($brandId): ?CatalogProductBrand
    {
        return self::find($brandId);
    }

    /**
     * Metodo usado para listar as marcas com Paginação
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getBrands(int $perPage = 20): LengthAwarePaginator
    {
        return self::getData()
            ->select([
                'brand_id as id',
                'brand_name as brand',
                'brand_key as slug'
            ])
            ->orderBy('brand_name')
            ->paginate($perPage);
    }

    /**
     * Retorna uma marca pelo brand_key
     * @param $brandKey
     * @return CatalogProductBrand|bool
     */
    public static function getBrandByKey($brandKey): ?CatalogProductBrand
    {

        $query = self::getData()
            ->where(
                column: 'brand_key',
                operator: '=',
                value: $brandKey
            );

        if ($query->exists())
            return $query->first();

        return null;

    }

    /**
     * Metodo usado para atualizar uma Marca no sistema
     * @param int $id
     * @param array $attributes
     * @return int
     */
    public static function update(int $id, array $attributes = []): int
    {
        return self::getData()->where(['brand_id' => $id])->update($attributes);
    }

    /**
     * Insere/Atualiza uma Marca no Sistema
     * @param int|null $id
     * @param array $values
     * @return \App\Models\CatalogProductBrand|null
     */
    public static function updateOrCreate(?int $id, array $values = []): ?CatalogProductBrand
    {
        return self::getData()->updateOrCreate(
            attributes: [
                'brand_id' => $id
            ],
            values: $values
        );
    }

}
