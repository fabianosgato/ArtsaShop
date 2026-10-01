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

namespace App\View\Components\Frontend;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{

    public string $layout;

    public function __construct(?string $layout = null)
    {

        // Se layout foi passado explicitamente (ex: produto, checkout)
        if ($layout) {
            $this->layout = $layout;
            return;
        }

        // Caso contrário, assume que é HOME e usa o layout da store
        $store = app('currentStore');

        // Retorna o layout da loja
        $this->layout = $store->layout;

    }

    public function render(): View
    {
        return view("frontend.layouts.{$this->layout}");
    }

}
