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
namespace Idea\Framework\Seo\Traits;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;

trait RenderableCollection
{
    public function render(): string
    {
        return $this->reduce(function (string $carry, Renderable $item): string {
            return $carry .= Str::of(
                $item->render()
            )->trim() . PHP_EOL;
        }, '');
    }
}
