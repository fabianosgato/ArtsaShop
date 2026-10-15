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

use App\Models\SysGroupProfile;
use Idea\Framework\Repository\AbstractRepository;

class SysGroupProfileRepository extends AbstractRepository
{

    protected static $model = SysGroupProfile::class;

    /**
     * Retorna as permissões de um grupo específico
     * @param int $groupId
     * @return array
     */
    public static function getPermissionsByGroup(int $groupId): array
    {

        $permissions = [];

        $profiles = self::loadModel()::query()
            ->where(
                column:'group_id',
                operator: '=',
                value: $groupId
            )
            ->get();

        foreach ($profiles as $profile) {

            $permissions[$profile->module_menu_id] = [
                'view' => (bool)$profile->view,
                'info' => (bool)$profile->info,
                'altr' => (bool)$profile->altr,
                'excl' => (bool)$profile->excl,
            ];

        }

        return $permissions;

    }

    public static function getPermission(int $groupId, int $moduleMenuId, string $action): bool
    {

        $profiles = self::loadModel()::query()
            ->where(
                column:'group_id',
                operator: '=',
                value: $groupId
            )
            ->where(
                column:'module_menu_id',
                operator: '=',
                value: $moduleMenuId
            )
            ->where(
                column:$action,
                operator: '=',
                value: true
            );

        if ($profiles->exists())
            return true;

        return false;

    }

}
