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

namespace Idea\Framework\Repository\Brand;

use App\Models\CatalogProductBrand;
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CatalogProductBrandRepository extends AbstractRepository
{

    // Inicializa o Model
    protected static $model = CatalogProductBrand::class;

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
     * Retorna uma marca pelo Id
     * @param $brandId
     * @return CatalogProductBrand
     */
    public static function getBrand($brandId): CatalogProductBrand
    {
        return self::find($brandId);
    }

    /**
     * Retorna uma marca pelo brand_key
     * @param $brandKey
     * @return array|bool
     */
    public static function getBrandByKey($brandKey): array|bool
    {
        $query = self::getData();

        $query->where(
            column: 'brand_key',
            operator: '=',
            value: $brandKey
        );

        if ($query->first())
            return $query->get()->first()->toArray();

        return false;

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
