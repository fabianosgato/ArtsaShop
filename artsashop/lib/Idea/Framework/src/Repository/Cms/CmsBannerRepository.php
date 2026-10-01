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

use App\Models\CmsBanner;
use Idea\Framework\Repository\AbstractRepository;

class CmsBannerRepository extends AbstractRepository
{

    protected static $model = CmsBanner::class;

    public static function updateOrCreate(?int $id, array $values = []): CmsBanner
    {
        return self::getData()->updateOrCreate(
            attributes: [
                'banner_id' => $id
            ],
            values: $values
        );
    }

}
