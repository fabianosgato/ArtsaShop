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
use Idea\Framework\Repository\System\SysUrlRewriteRepository;
use Illuminate\Http\Request;
use Modules\Brands\Http\Controllers\Frontend\BrandController;
use Modules\Catalog\Http\Controllers\Frontend\CatalogCategoryController;
use Modules\Catalog\Http\Controllers\Frontend\CatalogProductController;
use Modules\Cms\Http\Controllers\Frontend\CmsPagesController;

class UrlRewriteController extends Controller
{

    /**
     * Este método resolve as URLs vindas do sistema de rewrite.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|never
     */
    public function resolve(Request $request)
    {

        // Retorna o slug da página
        $slug = trim($request->path(), '/');

        // Retorna o slug
        $rewrite = SysUrlRewriteRepository::getBySlug($slug);

        // Valida as opções do redirect
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

}
