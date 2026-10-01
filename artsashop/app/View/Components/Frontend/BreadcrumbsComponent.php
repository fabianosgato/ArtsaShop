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

use Closure;
use Idea\Framework\View\Front\Breadcrumbs\Breadcrumbs;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BreadcrumbsComponent extends Component
{

    public $breadcrumbs;

    public function __construct()
    {
        // Verifica o contexto atual e prepara o render apropriado
        $this->breadcrumbs = $this->resolveBreadcrumb();

    }

    protected function resolveBreadcrumb()
    {

        if (app('router')->currentRouteName() != 'index.home') {

            // Se estiver uma rota nomeada com breadcrumb
            if (app('router')->currentRouteName()) {
                return Breadcrumbs::generate();
            }

            // Se estiver numa rota dinâmica (URL amigável)
            if (view()->shared('category')) {
                return Breadcrumbs::generate('category', view()->shared('category'));
            }

            if (view()->shared('brand')) {
                return Breadcrumbs::generate('brand', view()->shared('brand'));
            }

            if (view()->shared('product')) {
                return Breadcrumbs::generate('product', view()->shared('product'));
            }

            if (view()->shared('cms')) {
                return Breadcrumbs::generate('cms', view()->shared('cms'));
            }

        }

        return ''; // Nenhum breadcrumb aplicável

    }

    public function render(): View|Closure|string
    {
        return view('frontend.components.html.breadcrumbs');
    }

}
