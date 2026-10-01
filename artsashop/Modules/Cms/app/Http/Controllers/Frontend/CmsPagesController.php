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
namespace Modules\Cms\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Idea\Framework\Repository\Cms\CmsPageRepository;
use Idea\Framework\Seo\Traits\HasSeoResponse;
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

        // Compartilha as informacoes da página para o breadcrumb
        view()->share('cms', $page);

        // MetaTags da página
        $this->getSeoMetaTags(
            entity: $page
        );

        // Limpa ao HTML do content
        $regex = '/<a[^>]*>(<img[^>]*>).*?<figcaption[^>]*>.*?<\/figcaption>.*?<\/a>/is';
        $content = preg_replace($regex, '$1', $page->content);

        return view('cms::frontend.page', [
            'page' => [
                'title' => $page->title,
                'content' => $content,
            ]
        ]);

    }

}
