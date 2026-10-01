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

namespace Idea\Framework\Repository\Cms;

use App\Models\CmsPage;
use Idea\Framework\Repository\AbstractRepository;

class CmsPageRepository extends AbstractRepository
{

    protected static $model = CmsPage::class;

    public static function updateOrCreate(?int $id, array $values = []): CmsPage
    {
        return self::getData()->updateOrCreate(
            attributes: [
                'page_id' => $id
            ],
            values: $values
        );
    }

    public static function getPage($pageId): ?CmsPage
    {
        return self::getData()->find($pageId);
    }

}
