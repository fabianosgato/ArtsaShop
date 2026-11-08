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

use App\Models\User;
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;

class SysUserRepository extends AbstractRepository
{

    protected static $model = User::class;

    /**
     * Retorna todos os usuarios do sistema
     * @return Builder
     */
    public static function getData(): Builder
    {

        return User::query()
            ->addSelect([
                'sys_users.user_id',
                'sys_users.name',
                'sys_users.email',
                'sys_users.status',
                'sys_users.created_at',
                'sys_users.updated_at',
                'sys_group.group_id',
                'sys_group.group_name',
            ])
            ->join(
                table: 'sys_group',
                first: 'sys_group.group_id',
                operator: '=',
                second: 'sys_users.group_id'
            );

    }

    public static function update(int $id, array $attributes = []): int
    {
        return User::query()->where(['user_id' => $id])->update($attributes);
    }

    /**
     * Retorna os dados do usuario
     * @param int $userId
     * @return array
     */
    public static function getUserById(int $userId): array
    {

        // Inicializa a Query de Usuarios
        $query = self::getData();

        $query->where(
            column: 'sys_users.user_id',
            operator: '=',
            value: $userId
        );

        return $query->get()->first()->toArray();

    }

}

