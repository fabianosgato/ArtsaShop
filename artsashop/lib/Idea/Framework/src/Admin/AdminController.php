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

use App\Http\Controllers\Controller;
use App\Models\SysModulesMenu;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{

    public bool $buttonInsert = true;

    /**
     * Create a new controller instance.
     * @return void
     * @throws \Exception
     */
    public function __construct()
    {

        // Inicializa as rotas
        $route = Route::getCurrentRoute()->getName();

        // Valida a rota de nao e a login ou esta nula
        if (($route != 'login') && ($route != null)) {

            // Botao insert nos grids
            if (property_exists($this, 'buttonInsert'))
                View::share('buttonInsert', $this->buttonInsert);

            if ($route != 'livewire.update') {

                // Sempre irá pesquisar pela rota "index"
                $sysModulesMenus = SysModulesMenu::query()
                    ->where('menu_link', $route)
                    ->first();

                if (!is_null($sysModulesMenus)) {

                    if ($sysModulesMenus->menu_link != 'wsdadm.sysconfig') {

                        // Cria a sessao do nome do módulo
                        View::share('menuName', $sysModulesMenus->menu_name);

                        if (Route::getCurrentRoute()->getActionMethod() == 'index') {
                            View::share('actionInsert', "$route.insert");

                        } else {
                            // Desativa o botao de inserir
                            View::share('buttonInsert', false);

                            // Remove a rota do botao
                            View::share('actionInsert', "");

                        }

                    } else {
                        // Desativa o botao de inserir
                        View::share('buttonInsert', false);

                        // Remove a rota do botao
                        View::share('actionInsert', "");

                    }

                } else {
                    // Desativa o botao de inserir
                    View::share('buttonInsert', false);

                    // Remove a rota do botao
                    View::share('actionInsert', "");

                }

            }

        }

    }

}
