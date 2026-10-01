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

use App\Models\SysAddressState;
use Idea\Framework\Repository\AbstractRepository;

class SysAddressStateRepository extends AbstractRepository
{

    protected static $model = SysAddressState::class;

    public static function getStateByUf($uf)
    {

        $addressRegion = self::getData()
            ->where(
                column: 'uf_initials',
                operator: '=',
                value: $uf
            );

        if ($addressRegion->exists())
           return $addressRegion->first()->uf_description;

        return '';

    }

}
