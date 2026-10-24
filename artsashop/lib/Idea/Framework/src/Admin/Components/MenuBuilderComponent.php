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
