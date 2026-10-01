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
