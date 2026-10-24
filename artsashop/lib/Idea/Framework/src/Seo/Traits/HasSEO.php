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

use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSEO
{
    public function addSEO(): static
    {
        $this->seo()->create();

        return $this;
    }

    protected static function bootHasSEO(): void
    {
        static::created(fn (self $model): self => $model->addSEO());
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(config('seo.model'), 'model')->withDefault();
    }
}
