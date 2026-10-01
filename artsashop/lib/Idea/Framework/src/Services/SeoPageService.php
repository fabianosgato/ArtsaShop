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

namespace Idea\Framework\Services;

use Idea\Framework\Repository\Seo\SeoMetaTagRepository;
use Idea\Framework\Repository\Seo\SeoPageMetaTagRepository;
use Idea\Framework\Repository\Seo\SeoPageRepository;

class SeoPageService
{

    public function __construct(
        protected SeoPageRepository $seoPageRepository
    )
    {
    }

    public function getSeoPageData(int $objectId, string $object): array
    {

        // Inicializate array
        $data = [];

        // Busca os dados do SEO da página
        $seoPage = $this->seoPageRepository->findByObject(
            object: $object,
            objectId: $objectId
        );

        if ($seoPage) {

            $data = [
                'seo_page.path' => $seoPage->path,
                'seo_page.canonical_url' => $seoPage->canonical_url,
                'seo_page.title' => $seoPage->title,
                'seo_page.title_source' => $seoPage->title_source,
                'seo_page.description' => $seoPage->description,
                'seo_page.description_source' => $seoPage->description_source,
                'seo_page.robot_index' => $seoPage->robot_index,
                'seo_page.change_frequency' => $seoPage->change_frequency,
                'seo_page.priority' => $seoPage->priority,
                'seo_page.focus_keyword' => $seoPage->focus_keyword,
                'seo_page.tags' => $seoPage->tags,
            ];

            foreach ($seoPage->metaTags()->get() as $metaTag) {
                $data["seo_meta.{$metaTag->seo_meta_tag_id}"] = $metaTag->content;
            }

        }

        return $data;

    }

    public static function saveSeoData(int $objectId, string $object, array $seoPageData)
    {

        // Salva as informacoes do SEO da Página
        $seoPage = SeoPageRepository::saveOrUpdateByObject(
            object: $object,
            objectId: $objectId,
            seoPageData: $seoPageData
        );

        // Valida se o SeoPageData foi criado
        if ($seoPage) {

            // Retonra as metatags do sistema
            $seoMetaTags = SeoMetaTagRepository::getData()->get();

            foreach ($seoMetaTags as $seoMetaTag) {

                // Salva o valor da MetaTag para a página
                SeoPageMetaTagRepository::saveOrUpdate([
                    'seo_page_id' => $seoPage->seo_page_id,
                    'seo_meta_tag_id' => $seoMetaTag->seo_meta_tag_id,
                    'content' => $seoMetaTag->default_value
                ]);

            }

        }

    }

}
