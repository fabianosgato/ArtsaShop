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
