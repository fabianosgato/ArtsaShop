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

use App\Models\SysGroup;
use Idea\Framework\Repository\AbstractRepository;

class SysGroupRepository extends AbstractRepository
{
    protected static $model = SysGroup::class;

    public static function update(int $id, array $attributes = []): int
    {
        return self::loadModel()::query()->where(['group_id' => $id])->update($attributes);
    }

    /**
     * Retorna os grupos de usuarios do sistema
     * @return array
     */
    public static function getOptionsValues(): array
    {

        $options = [];

        $groups = self::loadModel()::query()->select([
            'group_id',
            'group_name'
        ])->get()->toArray();

        foreach ($groups as $group) {
            $options[$group['group_id']] = $group['group_name'];
        }

        return $options;

    }

}
