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
