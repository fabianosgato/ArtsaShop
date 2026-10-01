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

use Idea\Framework\Admin\Navigation\NavigationManager;
use Livewire\Component;

class MenuBuilderComponent extends Component
{

    public function render()
    {
        return view('idea-components::wsdadmin.pages.menus', [
            'menus' => NavigationManager::getMenuItems()
        ]);
    }

}
