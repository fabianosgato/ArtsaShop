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

use Filament\Forms\Components\Field;

class ExternalImageGallery extends Field
{

    protected string $view = 'idea-components::wsdadmin.forms.external-image-gallery';

    protected array $images = [];

    public function images(array $images): static
    {

        $this->images = $images;

        // Garante que o state seja preenchido ao hidratar o campo
        return $this->afterStateHydrated(function ($state, callable $set) use ($images) {
            if (empty($state)) {
                $set($this->getName(), $images);
            }
        });

    }
    public function getImages(): array
    {
        return $this->images ?? [];
    }


}
