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

use App\Models\SeoPageMetaTag;
use Idea\Framework\Repository\AbstractRepository;

class SeoPageMetaTagRepository extends AbstractRepository
{

    protected static $model = SeoPageMetaTag::class;

    public static function saveOrUpdate($attributes)
    {

        // Retorna os dados da MetaTag para serem atualizados
        $seoPageMetaTag = self::getData()->where(
            'seo_page_id',
            '=',
            $attributes['seo_page_id']
        )->where(
            'seo_meta_tag_id',
            '=',
            $attributes['seo_meta_tag_id']
        );

        // Insere/Atualiza os dadoss
        if ($seoPageMetaTag->exists()) {
            self::getData()->find($seoPageMetaTag->first()->seo_page_meta_tag_id)->update($attributes);
        } else {
            self::loadModel()::query()->firstOrCreate($attributes)->toArray();

        }

    }

}
