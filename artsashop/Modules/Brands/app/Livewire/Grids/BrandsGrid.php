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
namespace Modules\Brands\Livewire\Grids;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Models\CatalogProductBrand;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Idea\Framework\Admin\Grids\Grid;
use Idea\Framework\Repository\Brand\CatalogProductBrandRepository;

class BrandsGrid extends Grid
{

    public string $heading = 'Marcas Cadastradas';
    public string $prefix = 'brandsGrid';
    public string $primaryKey = 'brand_id';
    public string $sortField = 'brand_name';
    public string $sortDirection = 'asc';

    public function table(Tables\Table $table): Tables\Table
    {

        return $table
            ->query(CatalogProductBrandRepository::getData())
            ->heading($this->heading)
            ->columns([

                TextColumn::make('brand_id')
                    ->label("Id")
                    ->toggleable()
                    ->searchable(['brand_id']),

                TextColumn::make('brand_name')
                    ->label("Marca")
                    ->toggleable()
                    ->searchable(['brand_name']),

                TextColumn::make('brand_key')
                    ->label("KEY ")
                    ->toggleable()
                    ->searchable(['brand_key']),

                TextColumn::make('updated_at')
                    ->label("Atualizado em")
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->wrap()
                    ->toggleable()
                    ->dateTime('d/m/Y H:i:s'),

            ])
            ->recordActions([
                ActionGroup::make([

                    Action::make('edit')
                        ->label('Editar')
                        ->url(fn(CatalogProductBrand $record): string => route('wsdadm.brands.edit', [
                            'id' => $record->brand_id
                        ])),

                    DeleteAction::make()
                        ->label('Excluir')
                        ->icon(null)
                        ->modalHeading("Exclusão da Marca")
                        ->modalDescription("Deseja Excluir essa Marca")
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Exclusão da Marca')
                                ->body('Marca Excluída com Sucesso')
                        )
                ]),
            ])
            ->toolbarActions([
                FilamentExportBulkAction::make('export')
                    ->label('Exportar')
                    ->fileNameFieldLabel('Nome do Arquivo')
                    ->csvDelimiter(';')
                    ->defaultFormat('csv')
                    ->disablePdf()
                    ->disableXlsx()
            ])
            ->paginationPageOptions(
                options: $this->paginationPageOptions
            )
            ->striped()
            ->recordUrl(null)
            ->defaultSort(
                column: $this->sortField,
                direction: $this->sortDirection
            )
            ->persistColumnSearchesInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();

    }

}
