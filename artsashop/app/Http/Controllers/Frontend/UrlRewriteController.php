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
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Idea\Framework\Repository\Catalog\CatalogCategoryRepository;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Repository\System\SysUrlRewriteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\Brands\Http\Controllers\Frontend\BrandController;
use Modules\Catalog\Http\Controllers\Frontend\CatalogCategoryController;
use Modules\Catalog\Http\Controllers\Frontend\CatalogProductController;
use Modules\Cms\Http\Controllers\Frontend\CmsPagesController;

class UrlRewriteController extends Controller
{

    public function resolve(Request $request)
    {

        $slug = trim($request->path(), '/');

        $rewrite = SysUrlRewriteRepository::getBySlug($slug);

        if (!$rewrite) {

            if ($redirect = $this->resolveWooCategoryRedirect($slug)) {
                return redirect($redirect, 301);
            }

            if ($redirect = $this->resolveWooProductRedirect($slug)) {
                return redirect($redirect, 301);
            }

            abort(404);
        }

        // 🔥 NOVO: tratar redirect
        if (!empty($rewrite['options'])) {

            $options = json_decode($rewrite['options'], true);

            if (($options['redirect'] ?? null) === 301) {

                // Busca a URL canônica (principal)
                $canonical = SysUrlRewriteRepository::getCanonicalByTargetPath(
                    $rewrite['target_path']
                );

                if ($canonical && $canonical['request_path'] !== $slug) {
                    return redirect('/' . $canonical['request_path'], 301);
                }

            }

        }

        list($targetType, $id) = explode('/', $rewrite['target_path']);

        return match ($targetType) {
            'product'  => app(CatalogProductController::class)->index($id),
            'category' => app(CatalogCategoryController::class)->index($id),
            'brand'    => app(BrandController::class)->index($id),
            'cms'      => app(CmsPagesController::class)->index($id),
            default    => abort(404),
        };

    }

    /**
     * Resolve na URL do WooCommerce para fazer o redirect 301
     * @param string $slug
     * @return string|null
     */
    private function resolveWooProductRedirect(string $slug): ?string
    {
        // Só trata URLs do Woo
        if (!str_starts_with($slug, 'shop/')) {
            return null;
        }

        // Remove prefixo e barra final
        $oldSlug = str_replace('shop/', '', $slug);
        $oldSlug = rtrim($oldSlug, '/');

        return Cache::remember("woo_redirect:$oldSlug", 86400, function () use ($oldSlug) {

            // 1. Busca produto no Woo pelo slug
            $wooProduct = DB::connection('woocommerce')
                ->table('pmowe_posts')
                ->where('post_name', $oldSlug)
                ->where('post_type', 'product')
                ->where('post_status', 'publish')
                ->first();

            if (!$wooProduct) {
                return null;
            }

            // 2. Busca SKU no postmeta
            $sku = DB::connection('woocommerce')
                ->table('pmowe_postmeta')
                ->where('post_id', $wooProduct->ID)
                ->where('meta_key', '_sku')
                ->value('meta_value');

            if (!$sku) {
                return null;
            }

            // 3. Busca produto no Laravel pelo SKU
            $product = CatalogProductsRepository::getProductBySku($sku);

            if (!$product) {
                return null;
            }

            // 4. Resolve URL nova
            $rewrite = SysUrlRewriteRepository::getBySlug($product->slug_key);

            if (!$rewrite) {
                return null;
            }

            return '/' . $product->slug_key;
        });

    }

    private function resolveWooCategoryRedirect(string $slug): ?string
    {
        if (!str_starts_with($slug, 'product-category/')) {
            return null;
        }

        $cleanSlug = str_replace('product-category/', '', $slug);
        $cleanSlug = preg_replace('#/page/\d+$#', '', $cleanSlug);
        $cleanSlug = trim($cleanSlug, '/');

        $parts = explode('/', $cleanSlug);
        $lastSlug = end($parts);

        return Cache::remember("woo_category_name:$lastSlug", 86400, function () use ($lastSlug) {

            // 🔥 tenta encontrar categoria no Woo
            $category = DB::connection('woocommerce')
                ->table('pmowe_terms as t')
                ->join('pmowe_term_taxonomy as tt', 't.term_id', '=', 'tt.term_id')
                ->where('tt.taxonomy', 'product_cat')
                ->where('t.slug', 'LIKE', "%$lastSlug%")
                ->select('t.name')
                ->first();

            if (!$category) {
                return null;
            }

            // Usa seu método
            $catalogCategory = CatalogCategoryRepository::getCategoryByName($category->name);

            if (!$catalogCategory) {
                return null;
            }

            return '/' . $catalogCategory->slug_key;

        });

    }
}
