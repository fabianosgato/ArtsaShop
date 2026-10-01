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
namespace Idea\Framework\Repository\Cms;

use App\Models\CmsBlock;
use Idea\Framework\Repository\AbstractRepository;

class CmsBlockRepository extends AbstractRepository
{

    protected static $model = CmsBlock::class;

    public static function updateOrCreate(?int $id, array $values = []): CmsBlock
    {
        return self::getData()->updateOrCreate(
            attributes: [
                'block_id' => $id
            ],
            values: $values
        );
    }


}
