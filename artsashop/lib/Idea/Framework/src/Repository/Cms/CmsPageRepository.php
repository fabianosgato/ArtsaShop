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
