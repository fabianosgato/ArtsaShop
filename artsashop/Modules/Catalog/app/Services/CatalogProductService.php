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

namespace Modules\Catalog\Services;

use App\Models\CatalogProduct;
use App\Models\CatalogProductStatus;
use Idea\Framework\Repository\Brand\CatalogProductBrandRepository;
use Idea\Framework\Repository\Catalog\CatalogProductAttributeRepository;
use Idea\Framework\Repository\Catalog\CatalogProductCategoryRepository;
use Idea\Framework\Repository\Catalog\CatalogProductPricesRepository;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Repository\Catalog\CatalogProductStoreRepository;
use Idea\Framework\Repository\Eav\EavAttributesCategoryRepository;
use Idea\Framework\Repository\Eav\EavAttributeSetRepository;
use Idea\Framework\Repository\Eav\EavAttributesRepository;
use Idea\Framework\Repository\Seo\SeoPageRepository;
use Idea\Framework\Repository\System\SysStoreRepository;
use Idea\Framework\Repository\System\SysUrlRewriteRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Brands\Services\CatalogProductBrandService;
use Modules\Catalog\Jobs\ProcessCatalogProductQueue;
use Modules\Eav\Services\EavAttributeSetService;

class CatalogProductService
{

    /**
     * Metodo responsavel por retornar "Novos Produtos" no frontend
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getNewProducts(int $limit = 10): Collection
    {

        $cacheKey = "catalog:product-block:newProducts:limit:$limit";

        return Cache::remember(
            $cacheKey,
            now()->addHours(6),
            function () use ($limit) {
                return CatalogProductsRepository::getNewProducts(
                    limit: $limit
                );
            }
        );

    }

    /**
     * Metodo responsavel por retornar produtos de um grupo de atributos específico no frontend
     * @param $eavAttributeSetId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getCategoryProductBlock($eavAttributeSetId, int $limit = 4): Collection
    {

        $cacheKey = "catalog:product-block:set:$eavAttributeSetId:limit:$limit";

        return Cache::remember(
            $cacheKey,
            now()->addHours(6),
            function () use ($eavAttributeSetId, $limit) {
                return CatalogProductsRepository::getProductsBlock(
                    limit: $limit,
                    eavAttributeId: $eavAttributeSetId
                );
            }
        );
    }

    private static function getProductStatusId(int $productQuantity)
    {

        if ($productQuantity > 0) {
            $status = CatalogProductStatus::query()->where(
                column: 'status_key',
                operator: '=',
                value: 'in-stock'
            );
        } else {
            $status = CatalogProductStatus::query()->where(
                column: 'status_key',
                operator: '=',
                value: 'out-of-stock'
            );
        }

        if ($status->exists())
            // Retorna o status do produto pela quantidade
            return $status->first()->status_id;

        // Caso nao encotrado sempre retorna o status "Aguardando Processamento"
        return CatalogProductStatus::query()->find(2)->status_id;

    }

    /**
     * Normaliza os dados do Produto para inserção/atualização
     * @param $payload
     * @param $payloadSku
     * @param $eavAttributeSet
     * @param $catalogProductBrand
     * @return array
     */
    private static function productAttributes($payload, $payloadSku, $eavAttributeSet, $catalogProductBrand): array
    {

        // Seta os Atributos do produto para ser cadastrado no sistema
        return [
            'status_id' => self::getProductStatusId(
                productQuantity: $payloadSku['stock']['qty']
            ),
            'attribute_set_id' => $eavAttributeSet['attribute_set_id'],
            'brand_id' => $catalogProductBrand['brandId'],
            'sku' => $payloadSku['productSku'],
            'name' => $payload['name'],
            'description' => $payload['description'],
            'short_description' => $payload['shortDescription'],
            'slug_key' => Str::slug($payload['name']),
            'qty' => $payloadSku['stock']['qty'],
            'weight' => $payloadSku['dimensions']['weight'],
            'volume_weight' => $payloadSku['dimensions']['weight'],
            'height' => $payloadSku['dimensions']['height'],
            'width' => $payloadSku['dimensions']['width'],
            'length' => $payloadSku['dimensions']['length'],
            'video_url' => $payload['videoUrl'],
            'ean' => $payloadSku['ean']
        ];

    }

    /**
     * metodo responsavel por salvar os atributos dos produtos
     * @param array $payload
     * @return void
     */
    private static function updateAttributes(array $payload): void
    {

        foreach ($payload as $attribute => $value) {

            if (str_contains($attribute, 'attributes_')) {

                // Retorna o codigo do atributo
                $eavAttributeCode = str_replace("attributes_", "", $attribute);

                CatalogProductAttributeRepository::updateAttributes(
                    productId: $payload['product_id'],
                    atributeSetId: $payload['attribute_set_id'],
                    attributeCode: $eavAttributeCode,
                    value: $value
                );

            }

        }

    }

    /**
     * Valida os dados do produto para ser salvo no Banco de Dados
     * @param array $data
     * @return \App\Models\CatalogProduct|null
     * @throws \Throwable
     */
    public static function saveCatalogProduct(array $data): ?CatalogProduct
    {

        if (isset($data['sku'])) {

            // Retorna a Marca do produto
            $catalogProductBrand = CatalogProductBrandRepository::getBrand($data['brand_id']);

            // Retorna o Grupo de Atributos
            $eavAttribute = EavAttributeSetRepository::getAttributeSet($data['attribute_set_id']);

            // Monta um array com os dados para salvar o produto
            $payload = [
                'name' => $data['name'],
                'description' => $data['description'],
                'shortDescription' => $data['short_description'],
                'videoUrl' => $data['video_url'],
                'attributeSet' => [
                    'attributeSetKey' => $eavAttribute['attribute_set_key'],
                    'attributeSetName' => $eavAttribute['attribute_set_name']
                ],
                'brand' => [
                    'brandName' => $catalogProductBrand->brand_name,
                    'brandKey' => $catalogProductBrand->brand_key,
                ],
            ];

            if (!empty($data['store']))
                foreach ($data['store'] as $id => $store) {
                    if ($store) {
                        $payload['stores'][] = SysStoreRepository::getStoreById($id)->host;
                    }
                }

            // Monta o payload do SKU
            $payload['skus'][$data['sku']] = [
                'productSku' => $data['sku'],
                'ean' => $data['ean'],
                'prices' => [
                    'price' => $data['price'],
                    'finalPrice' => $data['final_price'],
                ],
                'stock' => [
                    'qty' => $data['qty'],
                    'tempoDePreparacao' => 20, // Tempo de preparação precisa ser criado no Form
                ],
                'dimensions' => [
                    'height' => $data['height'],
                    'length' => $data['length'],
                    'width' => $data['width'],
                    'weight' => $data['weight'],
                ]
            ];

            // Retorna os atributos do produto que estao no banco de dados
            $attributes = EavAttributesRepository::getAttributesBySetId($eavAttribute['attribute_set_id'])->get();

            if ($attributes) {
                foreach ($attributes as $attribute) {
                    $payload['skus'][$data['sku']]['attributes'][] = [
                        'attributeCode' => $attribute['attribute_code'],
                        'attributeValue' => $data["attributes_{$attribute['attribute_code']}"],
                    ];
                }
            }

            // Valida o array de imagens
            if (count($data['images']) == 0) {
                $payload['skus'][$data['sku']]['images'] = [];
            } else {
                foreach ($data['images'] as $image) {
                    $payload['skus'][$data['sku']]['images'][] = $image;
                }
            }

            // Retorna as informações do produto salvas
            return self::saveOrUpdate(
                productSku: $data['sku'],
                payload: $payload
            );

        }

        return null;

    }

    /**
     * Metodo responsavel por inserir/atualizar os dados de um produto
     * @param string $productSku
     * @param array $payload
     * @return \App\Models\CatalogProduct|null
     * @throws \Throwable
     */
    public static function saveOrUpdate(string $productSku, array $payload): ?CatalogProduct
    {

        DB::beginTransaction();

        try {

            // Define se irá processar as imagens do produto
            $processImage = false;

            $attributeSet = EavAttributeSetService::saveAttributeSet($payload['attributeSet'] ?? null);
            if (!$attributeSet) return null;

            $brandName = data_get($payload, 'brand.brandName');
            if (!$brandName) return null;

            $brand = CatalogProductBrandService::saveBrands([
                'brandName' => $brandName,
                'brandKey' => Str::slug($brandName),
                'brandUrl' => '',
            ]);
            if (!$brand) return null;

            $product = CatalogProductsRepository::getBaseProduct($productSku);

            foreach ($payload['skus'] as $skuData) {

                // Valida se as imagens estao sendo cadastradas
                if (count($skuData['images']) > 0)
                    $processImage = true;

                // Cria os atributos de produto
                $attributes = self::productAttributes(
                    $payload,
                    $skuData,
                    $attributeSet,
                    $brand
                );

                if (!$product) {
                    $product = CatalogProductsRepository::create($attributes);
                } else {
                    $product = CatalogProductsRepository::updateProduct($product->product_id, $attributes);
                }

                // Insere/Atualiza os Preços do produto
                CatalogProductPricesRepository::updatePrices(
                    productId: $product->product_id,
                    attributes: [
                        'product_id' => $product->product_id,
                        'price' => $skuData['prices']['price'] ?? 0,
                        'final_price' => $skuData['prices']['finalPrice'] ?? 0
                    ]
                );

                // Insere/Atualiza os atributos do produto
                CatalogProductAttributeService::saveProductAttributeValues(
                    productId: $product->product_id,
                    attributeSetId: $attributeSet['attribute_set_id'],
                    payloadAttributes: $skuData['attributes'] ?? []
                );

                // Salva os dados na SysUrlRewrite
                SysUrlRewriteRepository::saveUrlRewrite([
                    'request_path' => $attributes['slug_key'],
                    'target_path' => 'product/' . $product->product_id,
                    'target_type' => 'product',
                    'is_system' => 1,
                ]);

            }

            // stores
            if (!empty($payload['stores'])) {
                CatalogProductStoreRepository::deleteProductStores($product->product_id);

                foreach ($payload['stores'] as $store) {
                    CatalogProductStoreRepository::saveProductToStore(
                        storeHost: $store,
                        productId: $product->product_id
                    );
                }
            }

            // Vincula o produto à categoria
            CatalogCategoryProductService::saveProductCategories(
                productId: $product->product_id,
                path: $attributeSet['attribute_set_name'],
                productSlug: $product->slug_key
            );

            // Retorna a ultima categoria do produto
            $eavAttributesCategory = EavAttributesCategoryRepository::getCategoryByAttributeSetId(
                attributeSetId: $attributeSet->attribute_set_id
            );

            if ($eavAttributesCategory) {

                // Salva a ultima categoria do produto
                CatalogProductCategoryRepository::saveOrUpdate(
                    catalogProduct: $product,
                    attributes: [
                        'category_name' => $eavAttributesCategory->category,
                        'slug_key' => $eavAttributesCategory->slug_key
                    ]
                );

                // Cria uma Tag para o produto baseado na última categoria
                $payload['tags'][] = $eavAttributesCategory->category;

            }

            // Vincula as Tags de Produtos
            foreach ($payload['tags'] ?? [] as $tag) {
                CatalogProductsRepository::syncTags($product->product_id, $tag);
            }

            // Vincula as imagens ao Produto
            if ($processImage)
                CatalogProductMediaService::processImages(
                    dataPost: $payload,
                    productId: $product->product_id
                );

            DB::commit();

            // Vincula as informações de SEO do produto
            if (!empty($payload['seo'])) {
                self::saveSeo($product, $payload);
            }

            CatalogProductMediaService::proccessImages(
                catalogProduct: $product
            );

            // fila (fora da transação)
            CatalogProductQueueService::addToQueue(
                productId: $product->product_id,
                productSku: $product->sku,
                productJson: json_encode($payload)
            );

            // Dispatch do Queue
            ProcessCatalogProductQueue::dispatch();

            // Limpa o cache do produto
            Cache::forget("product_page_$product->product_id");
            Cache::forget("product_images_component_$product->product_id");

            return CatalogProductsRepository::getProductById($product->product_id);

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;

        }

    }

    /**
     * Metodo responsavel por salvar as informações de SEO do produto
     * @param \App\Models\CatalogProduct $catalogProduct
     * @param $payload
     * @return void
     */
    public static function saveSeo(CatalogProduct $catalogProduct, $payload): void
    {

        // Salva as informacoes do SEO do produto
        $seoPage = SeoPageRepository::saveOrUpdateByObject(
            object: 'product',
            objectId: $catalogProduct->product_id,
            seoPageData: [
                'object' => 'product',
                'object_id' => $catalogProduct->product_id,
                'path' => trim("{$catalogProduct->slug_key}-{$catalogProduct->product_id}"),
                'title' => $payload['seo']['title'] ?? $catalogProduct->name,
                'title_source' => $payload['seo']['titleSource'] ?? 'manual',
                'description' => $payload['seo']['description'] ?? '',
                'description_source' => $payload['seo']['descriptionSource'] ?? 'manual',
                'change_frequency' => $payload['seo']['changeFrequency'] ?? 'weekly',
                'priority' => $payload['seo']['priority'] ?? 0.5,
                'schema' => $payload['seo']['schema'] ?? '',
                'focus_keyword' => $payload['seo']['focusKeyword'] ?? '',
                'tags' => $payload['seo']['tags'] ?? '',
                'robot_index' => $payload['seo']['robotIndex'] ?? 'index',
                'robot_follow' => $payload['seo']['robotFollow'] ?? 'follow',
                'canonical_url' => url(trim($catalogProduct->slug_key)),
            ]
        );

        if ($seoPage) {

            // Imagem do Produto
            $payload['seo']['metaTags'][] = [
                'name' => 'og:image',
                'value' => $catalogProduct['image']
            ];

            foreach ($payload['seo']['metaTags'] as $idx => $metaTag) {
                if ($metaTag['name'] == 'og:image:alt') {
                    $payload['seo']['metaTags'][$idx]['value'] = $catalogProduct['name'];
                }

                if ($metaTag['name'] == 'og:image:width') {
                    $payload['seo']['metaTags'][$idx]['value'] = 300;
                }

                if ($metaTag['name'] == 'og:image:height') {
                    $payload['seo']['metaTags'][$idx]['value'] = 300;
                }

                if (($metaTag['name'] == 'og:video') && (!empty($catalogProduct->video_url))) {
                    $payload['seo']['metaTags'][$idx]['value'] = $catalogProduct->video_url;
                }

            }

            // Insere/Atualiza as informações das MetaTags
            app(SeoPageRepository::class)
                ->syncMetaTagsByProperty($seoPage->seo_page_id, $payload['seo']['metaTags']);

        }
    }

    public static function updateAttributeSet(int $productId, int $attributeSetId): void
    {
        CatalogProductsRepository::updateAttributeSetProduct(
            productId:$productId,
            attributeSetId:$attributeSetId
        );
    }

    /**
     * Metodo responsavel por Exluir o Produto do Sistema.
     * @param $productId
     * @return void
     */
    public static function deleteProduct($productId): void
    {

        // Exclui o produto definitivamente
        CatalogProductsRepository::deleteProduct($productId);

    }

}
