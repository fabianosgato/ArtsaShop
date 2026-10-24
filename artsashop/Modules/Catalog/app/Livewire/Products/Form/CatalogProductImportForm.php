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
namespace Modules\Catalog\Livewire\Products\Form;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Idea\Framework\Repository\Eav\EavAttributeSetRepository;
use Livewire\Component;

class CatalogProductImportForm extends Component implements HasForms
{

    use InteractsWithForms;

    public ?array $data = [];
    public string $title = 'Editar Produto';
    public $attachment;

    public function render()
    {
        return view('wsdadm.partials.forms.fields');
    }

    public function form(Form $form): Form
    {

        return $form->schema([

            Select::make('attribute_set_id')
                ->label('Selecione o Grupo de Atributos')
                ->options(EavAttributeSetRepository::getAttibuteSetOptions())
                ->required()
                ->searchable(),

            FileUpload::make('attachment')
                ->label('Arquivo de Asins')
//                ->storeFiles(true)
//                ->fetchFileInformation(false)
                ->acceptedFileTypes(['text/csv'])
                ->maxSize(500)


        ]);

    }

}
