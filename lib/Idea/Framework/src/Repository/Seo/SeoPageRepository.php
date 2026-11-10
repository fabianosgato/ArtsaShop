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
declare(strict_types=1);

namespace Idea\Framework\Repository\Seo;

use App\Models\SeoPage;
use Idea\Framework\Contracts\Seo\SeoAware;
use Idea\Framework\Repository\AbstractRepository;

class SeoPageRepository extends AbstractRepository
{

    protected static $model = SeoPage::class;

    public static function getSeoFor(SeoAware $entity): ?SeoPage
    {
        return SeoPage::query()
            ->where('object', '=', $entity->getSeoObject())
            ->where('object_id', '=', $entity->getSeoObjectId())
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
        // Busca TODOS os registros para este object/objectId, ordenados por ID (primário = mais antigo)
        $seoPages = self::getData()
            ->where('object', '=', $object)
            ->where('object_id', '=', $objectId)
            ->orderBy('seo_page_id')
            ->get();

        if ($seoPages->isEmpty()) {
            // Não existe → Cria novo
            return self::createSeoData($seoPageData);
        }

        // Existe pelo menos 1 → O primeiro é o primário
        $primary = $seoPages->first();

        if ($seoPages->count() > 1) {
            // Tem duplicatas → Apaga APENAS os extras (IDs > primário)
            $duplicateIds = $seoPages->skip(1)->pluck('seo_page_id')->toArray();

            if (!empty($duplicateIds)) {
                self::getData()
                    ->whereIn('seo_page_id', $duplicateIds)
                    ->delete();

                // Log para auditoria
                \Illuminate\Support\Facades\Log::warning('SEO duplicatas removidas', [
                    'object' => $object,
                    'object_id' => $objectId,
                    'deleted_ids' => $duplicateIds,
                    'kept_id' => $primary->seo_page_id,
                ]);
            }
        }

        // Preserva description se não enviada
        if (empty($seoPageData['description'])) {
            $seoPageData['description'] = $primary->description;
        }

        // Atualiza o primário
        $primary->update($seoPageData);

        return self::findByObject($object, $objectId);
    }

}
