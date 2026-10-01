<?php

namespace Modules\Brands\Services;

use Idea\Framework\Repository\Brand\CatalogProductBrandRepository;
use Idea\Framework\Repository\System\SysUrlRewriteRepository;
use Idea\Framework\Services\SeoPageService;

class CatalogProductBrandService
{

    public static function serviceValidator(array $brandData): array
    {

        return [
            'brand_name' => $brandData['brandName'],
            'brand_key' => $brandData['brandKey'],
            'brand_url' => $brandData['brandUrl']
        ];

    }

    /**
     * Metodo reponsavel por Salvar uma Marca no sistema
     * @param $brandData
     * @return array
     */
    public static function saveBrands($brandData): array
    {

        $catalogBrandRepository = CatalogProductBrandRepository::getBrandByKey(
            brandKey: $brandData['brandKey']
        );

        if (!$catalogBrandRepository) {

            // Cria a marca no sistema
            $catalogProductBrand = CatalogProductBrandRepository::create(
                attributes: self::serviceValidator($brandData)
            );

            // Insere/Atualiza os dados de SEO da marca
            SeoPageService::saveSeoData(
                objectId: $catalogProductBrand->brand_id,
                object: 'brand',
                seoPageData:  [
                    'object' => 'brand',
                    'object_id' => $catalogProductBrand->brand_id,
                    'path' => trim($catalogProductBrand->brand_key),
                    'title' => $catalogProductBrand->brand_name,
                    'title_source' => 'manual',
                    'description' => '',
                    'description_source' => 'manual',
                    'change_frequency' => 'weekly',
                    'priority' => 0.5,
                    'schema' => '',
                    'focus_keyword' => '',
                    'tags' => '',
                    'robot_index' => 'index',
                    'robot_follow' => 'follow',
                    'canonical_url' => url(trim($catalogProductBrand->brand_key)),
                ]
            );

            // Salva os dados na SysUrlRewrite
            SysUrlRewriteRepository::saveUrlRewrite([
                'request_path' => $catalogProductBrand->brand_key,
                'target_path'  => 'brand/' . $catalogProductBrand->brand_id,
                'target_type'  => 'brand',
                'is_system'    => 1,
            ]);

            return [
                'brandId' => $catalogProductBrand->brand_id,
                'brandName' => $catalogProductBrand->brand_name,
                'brandKey' => $catalogProductBrand->brand_key
            ];

        } else {

            // Atualiza a marca no sistema
            CatalogProductBrandRepository::update(
                id: $catalogBrandRepository['brand_id'],
                attributes: self::serviceValidator($brandData)
            );

            $catalogBrandRepository = CatalogProductBrandRepository::getBrandByKey(
                brandKey: $brandData['brandKey']
            );

            // Insere/Atualiza os dados de SEO da marca
            SeoPageService::saveSeoData(
                objectId: $catalogBrandRepository['brand_id'],
                object: 'brand',
                seoPageData:  [
                    'object' => 'brand',
                    'object_id' => $catalogBrandRepository['brand_id'],
                    'path' => trim($catalogBrandRepository['brand_key']),
                    'title' => $catalogBrandRepository['brand_name'],
                    'title_source' => 'manual',
                    'description' => '',
                    'description_source' => 'manual',
                    'change_frequency' => 'weekly',
                    'priority' => 0.5,
                    'schema' => '',
                    'focus_keyword' => '',
                    'tags' => '',
                    'robot_index' => 'index',
                    'robot_follow' => 'follow',
                    'canonical_url' => url(trim($catalogBrandRepository['brand_key'])),
                ]
            );

            // Salva os dados na SysUrlRewrite
            SysUrlRewriteRepository::saveUrlRewrite([
                'request_path' => $catalogBrandRepository['brand_key'],
                'target_path'  => 'brand/' . $catalogBrandRepository['brand_id'],
                'target_type'  => 'brand',
                'is_system'    => 1,
            ]);

            return [
                'brandId' => $catalogBrandRepository['brand_id'],
                'brandName' => $catalogBrandRepository['brand_name'],
                'brandKey' => $catalogBrandRepository['brand_key']
            ];

        }

    }

}
