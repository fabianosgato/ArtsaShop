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
namespace Idea\Framework\Admin\Components;

use App\Models\SysModulesMenu;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class GridsTitlesCompoments extends Component
{

    public function render()
    {

        // Retorna a rota atual
        $routeName = Route::getCurrentRoute()->getPrefix();

        // Seleciona o grupo
        $sysModuleMenus = SysModulesMenu::query()
            ->where(
                column: 'access_type',
                operator: '=',
                value: $routeName
            );

        if ($sysModuleMenus->exists()) {
            return view('idea-components::wsdadmin.pages.title', ['title' => $sysModuleMenus->first()->menu_name]);

        } else {
            return view('idea-components::wsdadmin.pages.title', [
                'title' => 'SEM NOME PARA: '.$routeName
            ]);

        }

    }

}
