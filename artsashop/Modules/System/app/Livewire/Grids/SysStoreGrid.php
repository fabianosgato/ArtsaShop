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

namespace Modules\System\Livewire\Grids;

use App\Models\SysStore;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Idea\Framework\Admin\Grids\Grid;
use Idea\Framework\Repository\System\SysStoreRepository;

class SysStoreGrid extends Grid
{

    protected string $heading = 'Lojas Habilitadas';
    public string $primaryKey = 'store_id';
    public string $sortDirection = 'desc';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(SysStoreRepository::getData())
            ->heading($this->heading)
            ->columns([
                TextColumn::make('store_name')
                    ->label("Nome da Loja")
                    ->toggleable(false)
                    ->searchable(['store_name']),

                TextColumn::make('host')
                    ->label("URL")
                    ->toggleable(false)
                    ->searchable(['host']),

                TextColumn::make('code')
                    ->label("Store Code")
                    ->toggleable(false)
                    ->searchable(['code'])
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

                TextColumn::make('type')
                    ->label("Tipo")
                    ->toggleable(false)
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->searchable(false)
                    ->formatStateUsing(function ($state) {
                        if ($state == 'default') {
                            return 'Loja Padrão';
                        } elseif ($state == 'category') {
                            return 'Loja de Categoria';
                        }
                        return 'Não definido';
                    })
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

                TextColumn::make('is_default')
                    ->label("Padrão")
                    ->toggleable(false)
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->searchable(['is_default'])
                    ->formatStateUsing(function ($state) {
                        return ($state == 1 ? 'Sim' : 'Não');
                    })
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('edit')
                        ->label('Editar')
                        ->url(fn(SysStore $record): string => route('wsdadm.sysstore.edit', [
                            'id' => $record->store_id
                        ])),
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
