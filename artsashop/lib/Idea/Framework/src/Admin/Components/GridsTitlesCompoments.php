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
