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

use App\Models\CmsFaq;
use Idea\Framework\Repository\AbstractRepository;

class CmsFaqRepository extends AbstractRepository
{

    protected static $model = CmsFaq::class;

    public static function updateOrCreate(?int $id, array $values = []): CmsFaq
    {
        return self::getData()->updateOrCreate(
            attributes: [
                'faq_id' => $id
            ],
            values: $values
        );
    }

}
