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

namespace Idea\Framework\Repository\System;

use App\Models\SysCarrier;
use Idea\Framework\Repository\AbstractRepository;

class SysCarrierRepository extends AbstractRepository
{

    protected static $model = SysCarrier::class;

    public static function updateOrCreate(?int $id, array $values = []): SysCarrier
    {

        return self::getData()->updateOrCreate(
            attributes: [
                'carrier_id' => $id
            ],
            values: $values
        );

    }

}
