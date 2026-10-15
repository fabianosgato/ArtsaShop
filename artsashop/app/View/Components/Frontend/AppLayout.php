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
