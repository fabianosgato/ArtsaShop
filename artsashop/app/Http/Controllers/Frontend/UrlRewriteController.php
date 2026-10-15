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
     */
    public function resolve(Request $request)
    {

        // Retorna o slug da página
        $slug = trim($request->path(), '/');

        // Retorna o slug
        $rewrite = SysUrlRewriteRepository::getBySlug($slug);

        if ($rewrite) {

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
                'product' => app(CatalogProductController::class)->index($id),
                'category' => app(CatalogCategoryController::class)->index($id),
                'brand' => app(BrandController::class)->index($id),
                'cms' => app(CmsPagesController::class)->index($id),
                default => abort(404),
            };
        }

    }

}
