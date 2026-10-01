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
namespace Idea\Framework\Admin;

use Idea\Framework\Repository\System\SysGroupProfileRepository;
use Idea\Framework\Repository\System\SysUserRepository;
use Illuminate\Support\Facades\Auth;

class Permissions
{

    /**
     * Retorna o nome do grupo do sistema
     */
    public static function getUserData(): array
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
    public static function checkPermissions(int $moduleMenuId, string $action): bool
    {

        // Retorna os dados do usuario
        $userData = self::getUserData();

        // Inicializa o repositorio
        $sysGroupProfile = SysGroupProfileRepository::getData();

        // Filta pelo Usuario
        $sysGroupProfile->where(
            column: 'group_id',
            operator: '=',
            value:$userData['group_id']
        );

        $sysGroupProfile->where(
            column: 'module_menu_id',
            operator: '=',
            value:$moduleMenuId
        );

        if ($sysGroupProfile->exists()) {
            // Retorna as permissoes do usuario
            $permissions = $sysGroupProfile->first()->toArray();

            if (isset($permissions[$action]))
                return $permissions[$action];

        }

        return false;

    }

}
