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
