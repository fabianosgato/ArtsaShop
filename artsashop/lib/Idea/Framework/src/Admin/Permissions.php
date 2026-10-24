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
namespace Idea\Framework\Admin;

use Idea\Framework\Repository\System\SysGroupProfileRepository;
use Idea\Framework\Repository\System\SysUserRepository;
use Illuminate\Support\Facades\Auth;

class Permissions
{

    /**
     * Retorna o nome do grupo do sistema
     * @return array
     */
    public function getUserData(): array
    {
        // Retorna os dados do Usuario do sistema
        return SysUserRepository::getUserById(
            userId: Auth::user()->getAuthIdentifier()
        );
    }

    /**
     * Método que verifica o acesso aos módulos
     *
     */
    public function checkPermissions(int $moduleMenuId, string $action): bool
    {

        // Retorna os dados do usuario
        $userData = self::getUserData();

        // Valida se o usuário possui permissão pelo grupo
        $sysGroupProfile = SysGroupProfileRepository::getPermission(
            groupId: $userData['group_id'],
            moduleMenuId: $moduleMenuId,
            action: $action
        );

        if (count($sysGroupProfile) > 0) {
            if (isset($sysGroupProfile[$action]))
                return $sysGroupProfile[$action];

        }

        return false;

    }

}
