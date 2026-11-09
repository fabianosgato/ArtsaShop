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

use App\Models\CatalogProduct;
use App\Models\CatalogProductBrand;
use App\Models\SeoPage;
use App\Models\SysUrlRewrite;
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

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
     * Exclui definitivamente uma marca e suas relações.
     * @param int $brandId
     * @return void
     * @throws \Exception|\Throwable Se a marca tiver produtos associados
     */
    public static function deleteBrand(int $brandId): void
    {
        DB::beginTransaction();

        try {
            // Verifica se a marca tem produtos associados
            $productsCount = CatalogProduct::query()
                ->where('brand_id', $brandId)
                ->count();

            if ($productsCount > 0) {
                throw new \Exception("Não é possível excluir a marca: existem {$productsCount} produto(s) associado(s).");
            }

            // 1. URL Rewrites (target_type=brand, target_path=brand/{id})
            SysUrlRewrite::query()
                ->where('target_type', 'brand')
                ->where('target_path', 'brand/' . $brandId)
                ->delete();

            // 2. SEO Pages (object=brand, object_id=brandId)
            // As tabelas filhas (meta_tags, images, link_tags) sao limpas via FK CASCADE
            SeoPage::query()
                ->where('object', 'brand')
                ->where('object_id', (string) $brandId)
                ->delete();

            // 3. Por fim, exclui a marca
            CatalogProductBrand::query()
                ->where('brand_id', $brandId)
                ->delete();

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
