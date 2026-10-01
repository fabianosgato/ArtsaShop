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
namespace Idea\Framework\Admin\Navigation;

use App\Models\SysModule;
use App\Models\SysModulesMenu;
use Idea\Framework\Admin\Permissions;
use Illuminate\Support\Facades\Route;


class NavigationManager
{

    /**
     * Valida se o menu está ativo pela rota obtida
     * @param $moduleId
     * @return bool
     */
    private static function checkIsActive($moduleId): bool
    {

        $isActive = false;

        if (count(explode('.', Route::getCurrentRoute()->getName())) > 2) {

            // Rota padrao de cada modulo
            $routeDefaultName = substr(
                string: Route::getCurrentRoute()->getName(),
                offset: 0,
                length: strrpos(
                    haystack: Route::getCurrentRoute()->getName(),
                    needle: '.'
                ));

        } else {
            $routeDefaultName = Route::getCurrentRoute()->getName();
        }

        $menus = SysModulesMenu::all()->where('module_id', $moduleId)->toArray();

        foreach ($menus as $menu) {
            if ($menu['menu_link'] == $routeDefaultName) {
                $isActive = true;
            }
        }

        return $isActive;

    }


    /**
     * Este método retorna itens de menu dependendo se o usuario está conectado ou não.
     */
    public static function getMenuItems(): array
    {

        $menuData = [];

        // Seleciona todos os modulos do sistema que estao ativos
        $modules = SysModule::all()
            ->where('status', true)
            ->sortBy('module_order');

        foreach ($modules as $module) {

            // Query que retorna todos os Submenus de cada Modulo
            $menus = SysModulesMenu::all()
                ->where('module_id', $module['module_id'])
                ->where('status', true)
                ->where('is_visible', true)
                ->sortBy('menu_order');

            $menuData['menu_'.$module['module_id']] = [
                'key' => 'menu_'.$module['module_id'],
                'text' => $module['module_name'],
                'url' => strtolower($module['module_name']),
                'status' => 'close',
                'icon' => $module['icon'] == '' ? 'fa fa-table':$module['icon']
            ];

            foreach ($menus as $menu) {

                // Retorna os dados do usuario
                $permission = Permissions::checkPermissions(
                    moduleMenuId: $menu['module_menu_id'],
                    action:'view'
                );

                if ($permission)

                    $class = '';

                    if ($menu['menu_link'] == Route::getCurrentRoute()->getName()) {
                        $class = 'dy-active';
                        $menuData['menu_'.$module['module_id']]['status'] = 'open';
                    }

                    // Submenus dos Modulos
                    $menuData['menu_'.$menu['module_id']]['submenu']["submenu_{$menu['module_menu_id']}"] = [
                        'key' => "{$menu['menu_link']}",
                        'text' => $menu['menu_name'],
                        'url' => route($menu['menu_link']),
                        'class' => $class
                    ];

            }

        }

        return $menuData;

    }

}
