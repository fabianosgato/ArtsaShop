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

        $catalogBrand = CatalogProductBrandRepository::getBrandByKey(
            brandKey: $brandData['brandKey']
        );

        if (!$catalogBrand) {

            // Cria a marca no sistema
            $catalogBrand = CatalogProductBrandRepository::create(
                attributes: self::serviceValidator($brandData)
            );
        }

        // Insere/Atualiza os dados de SEO da marca
        SeoPageService::saveSeoData(
            objectId: $catalogBrand->brand_id,
            object: 'brand',
            seoPageData:  [
                'object' => 'brand',
                'object_id' => $catalogBrand->brand_id,
                'path' => trim($catalogBrand->brand_key),
                'title' => $catalogBrand->brand_name,
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
                'canonical_url' => url(trim($catalogBrand->brand_key)),
            ]
        );

        // Salva os dados na SysUrlRewrite
        SysUrlRewriteRepository::saveUrlRewrite([
            'request_path' => $catalogBrand->brand_key,
            'target_path'  => 'brand/' . $catalogBrand->brand_id,
            'target_type'  => 'brand',
            'is_system'    => 1,
        ]);

        return [
            'brandId' => $catalogBrand->brand_id,
            'brandName' => $catalogBrand->brand_name,
            'brandKey' => $catalogBrand->brand_key
        ];

    }

}
