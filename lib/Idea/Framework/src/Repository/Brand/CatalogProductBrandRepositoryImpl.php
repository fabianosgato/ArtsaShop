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
use Idea\Framework\Repository\Brand\Contracts\CatalogProductBrandRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CatalogProductBrandRepositoryImpl implements CatalogProductBrandRepositoryInterface
{
    protected static string $model = CatalogProductBrand::class;

    protected static function model(): \Illuminate\Database\Eloquent\Builder
    {
        return app(static::$model)::query();
    }

    /**
     * Retorna uma marca pelo Id
     * @param int $brandId
     * @return \App\Models\CatalogProductBrand|null
     */
    public function getBrand(int $brandId): ?CatalogProductBrand
    {
        return $this->find($brandId);
    }

    /**
     * Encontra uma marca pelo ID
     * @param int $id
     * @return \App\Models\CatalogProductBrand|null
     */
    public function find(int $id): ?CatalogProductBrand
    {
        return $this->model()->find($id);
    }

    /**
     * Metodo usado para listar as marcas com Paginação
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getBrands(int $perPage = 20): LengthAwarePaginator
    {
        return $this->model()
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
     * @param string $brandKey
     * @return CatalogProductBrand|null
     */
    public function getBrandByKey(string $brandKey): ?CatalogProductBrand
    {
        $query = $this->model()
            ->where('brand_key', '=', $brandKey);

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
    public function deleteBrand(int $brandId): void
    {
        DB::beginTransaction();

        try {
            // Verifica se a marca tem produtos associados
            $productsCount = CatalogProduct::query()
                ->where('brand_id', '=', $brandId)
                ->count();

            if ($productsCount > 0) {
                throw new \Exception("Não é possível excluir a marca: existem {$productsCount} produto(s) associado(s).");
            }

            // 1. URL Rewrites (target_type=brand, target_path=brand/{id})
            SysUrlRewrite::query()
                ->where('target_type', '=', 'brand')
                ->where('target_path', '=', 'brand/' . $brandId)
                ->delete();

            // 2. SEO Pages (object=brand, object_id=brandId)
            // As tabelas filhas (meta_tags, images, link_tags) sao limpas via FK CASCADE
            SeoPage::query()
                ->where('object', '=', 'brand')
                ->where('object_id', '=', (string) $brandId)
                ->delete();

            // 3. Por fim, exclui a marca
            CatalogProductBrand::query()
                ->where('brand_id', '=', $brandId)
                ->delete();

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->model()->updateOrCreate($attributes, $values);
    }

}
