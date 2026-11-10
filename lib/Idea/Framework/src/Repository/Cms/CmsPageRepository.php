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

namespace Idea\Framework\Repository\Cms;

use App\Models\CmsPage;
use App\Models\SeoPage;
use App\Models\SysUrlRewrite;
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Support\Facades\DB;

class CmsPageRepository extends AbstractRepository
{

    protected static $model = CmsPage::class;

    public static function getPage($pageId): ?CmsPage
    {
        return self::getData()->find($pageId);
    }

    /**
     * Exclui definitivamente uma página CMS e suas relações.
     * @param int $pageId
     * @return void
     */
    public static function deletePage(int $pageId): void
    {
        DB::beginTransaction();

        try {
            // 1. URL Rewrites (target_type=cms, target_path=cms/{id})
            SysUrlRewrite::query()
                ->where('target_type', '=', 'cms')
                ->where('target_path', '=', 'cms/' . $pageId)
                ->delete();

            // 2. SEO Pages (object=cms, object_id=pageId)
            // As tabelas filhas (meta_tags, images, link_tags) sao limpas via FK CASCADE
            SeoPage::query()
                ->where('object', '=', 'cms')
                ->where('object_id', '=', (string) $pageId)
                ->delete();

            // 3. Por fim, exclui a página CMS
            CmsPage::query()
                ->where('page_id', '=', $pageId)
                ->delete();

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

}