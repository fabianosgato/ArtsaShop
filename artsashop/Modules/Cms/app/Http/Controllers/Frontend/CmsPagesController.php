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
namespace Modules\Cms\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Idea\Framework\Repository\Cms\CmsPageRepository;
use Idea\Framework\Seo\Traits\HasSeoResponse;
use Inertia\Inertia;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class CmsPagesController extends Controller
{

    use HasSeoResponse;

    /**
     * Display a listing of the resource.
     */
    public function index(int $pageId)
    {

        // Retorna a pagina pelo ID
        $page = CmsPageRepository::getPage($pageId);

        if (!$page)
            abort(404);

        // Compartilha as informacoes da página para o breadcrumb
        view()->share('cms', $page);

        // MetaTags da página
        $this->getSeoMetaTags(
            entity: $page
        );

        // Limpa ao HTML do content
        $regex = '/<a[^>]*>(<img[^>]*>).*?<figcaption[^>]*>.*?<\/figcaption>.*?<\/a>/is';
        $content = preg_replace($regex, '$1', $page->content);

        return Inertia::render('Cms::Page', [
            'CmsPage' => [
                'title' => $page->title,
                'content' => $content,
            ]
        ]);

    }

}
