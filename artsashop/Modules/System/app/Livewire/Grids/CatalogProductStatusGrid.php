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
namespace Modules\System\Livewire\Grids;

use App\Models\CatalogProductStatus;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Idea\Framework\Admin\Grids\Grid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class CatalogProductStatusGrid extends Grid
{

    public string $heading = 'Status de Produtos';
    public string $primaryKey = 'status_id';
    public string $sortDirection = 'desc';

    /**
     * Retorna o DataSource para o Grid
     * @return Builder
     */
    public function datasource(): Builder
    {
        return CatalogProductStatus::query();
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query($this->datasource())
            ->heading($this->heading)
            ->columns([
                TextColumn::make('status')
                    ->label("Nome STATUS")
                    ->wrap()
                    ->toggleable()
                    ->searchable(['status']),

                TextColumn::make('status_key')
                    ->label("KEY STATUS")
                    ->wrap()
                    ->toggleable()
                    ->searchable(['status_key']),

            ])
            ->recordActions([

                ActionGroup::make([

                    Action::make('edit')
                        ->label('Editar')
                        ->url(fn(Model $record): string => route('wsdadm.product-status.edit', [
                            'id' => $record->status_id
                        ])),

                    DeleteAction::make()
                        ->label('Excluir')
                        ->icon(null)
                        ->modalHeading("Exclusão do Status de Produto")
                        ->modalDescription("Deseja Excluir esse status de Produto")
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Status de Produto Excluído')
                                ->body('Status de Produto foi excluido com sucesso')
                        )

                ])
            ])
            ->paginationPageOptions(
                options: $this->paginationPageOptions
            )
            ->striped()
            ->recordUrl(null)
            ->defaultSort(
                column: $this->primaryKey,
                direction: $this->sortDirection
            )
            ->persistFiltersInSession();

    }

}
