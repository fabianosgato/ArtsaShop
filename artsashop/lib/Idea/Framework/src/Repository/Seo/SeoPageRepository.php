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
declare(strict_types=1);

namespace Idea\Framework\Repository\Seo;

use App\Models\SeoPage;
use Idea\Framework\Repository\AbstractRepository;
use Idea\Framework\Seo\Contracts\SeoAware;

class SeoPageRepository extends AbstractRepository
{

    protected static $model = SeoPage::class;

    public static function getSeoFor(SeoAware $entity): ?SeoPage
    {
        return SeoPage::query()
            ->where('object', $entity->getSeoObject())
            ->where('object_id', $entity->getSeoObjectId())
            ->first();
    }

    public static function findByObject(string $object, string $objectId): ?SeoPage
    {
        return SeoPage::with('metaTags')
            ->where('object', '=', $object)
            ->where('object_id', '=', $objectId)
            ->first();
    }

    public function syncMetaTags(int $seoPageId, array $data): void
    {

        foreach ($data as $metaTagId => $content) {
            if (!is_array($content)) {
                SeoPageMetaTagRepository::saveOrUpdate([
                    'seo_page_id' => $seoPageId,
                    'seo_meta_tag_id' => $metaTagId,
                    'content' => $content
                ]);
            }
        }

    }

    public function syncMetaTagsByProperty(int $seoPageId, array $metaData): void
    {

        foreach ($metaData as $meta) {

            if (!empty($meta['value'])) {

                // Busca pelo nome da Tag
                $seoPageMetaTag = SeoMetaTagRepository::getData()->where(
                    column: 'property',
                    operator: '=',
                    value: $meta['name']
                );

                if ($seoPageMetaTag->exists()) {

                    // Salva o valor da MetaTag
                    SeoPageMetaTagRepository::saveOrUpdate([
                        'seo_page_id' => $seoPageId,
                        'seo_meta_tag_id' => $seoPageMetaTag->first()->seo_meta_tag_id,
                        'content' => $meta['value']
                    ]);
                }
            }
        }

    }

    protected static function createSeoData(array $seoPageData)
    {
        return self::getData()->firstOrCreate(
            $seoPageData
        );
    }

    /**
     * Insere/Atualiza as informações do SEO da página
     * @param string $object
     * @param string $objectId
     * @param array $seoPageData
     * @return \App\Models\SeoPage|null
     */
    public static function saveOrUpdateByObject(string $object, string $objectId, array $seoPageData): ?SeoPage
    {

        // Busca pela página se ela existe
        $seoPage = self::getData()
            ->where(
                column: 'object',
                operator: '=',
                value: $object
            )
            ->where(
                column: 'object_id',
                operator: '=',
                value: $objectId
            );

        // Se existir irá atualizar
        if ($seoPage->exists()) {

            // Verifica se existem mais de 2 registros
            if (count($seoPage->get()->toArray()) > 1) {

                // Exclui tudo relacionado ao SEO
                $seoPage->delete();

                // Cria novamente o novo registro no banco de dados
                return self::createSeoData(
                    $seoPageData
                );

            }

            // Retorna o array do dados SEO do Object
            $seoData = $seoPage->first()->toArray();

            // Permanece a mesma description
            if (empty($seoPageData['description']))
                $seoPageData['description'] = $seoData['description'];

            self::getData()->find($seoPage->first()->seo_page_id)->update(
                $seoPageData
            );

            return self::findByObject($object, $objectId);

        } else {

            // Cria novamente o novo registro no banco de dados
            return self::createSeoData(
                $seoPageData
            );

        }

    }

}
