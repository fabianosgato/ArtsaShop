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

use App\Models\SysCarrier;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Idea\Framework\Admin\Grids\Grid;

class SysCarrierGrid extends Grid
{

    protected string $heading = 'Transportadoras do Sistema';
    protected string $primaryKey = 'carrier_id';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(SysCarrier::query())
            ->heading($this->heading)
            ->columns([

                TextColumn::make('carrier_id')
                    ->label("Id")
                    ->toggleable()
                    ->searchable(['carrier_id'])
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

                TextColumn::make('carrier_name')
                    ->label("Transportadora")
                    ->toggleable()
                    ->searchable(['carrier_name']),

                TextColumn::make('status')
                    ->label("Ativo")
                    ->toggleable()
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->searchable(['sys_users.status'])
                    ->formatStateUsing(function ($state) {
                        return ($state == 1 ? 'Habilitado' : 'Desabilitado');
                    })
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

            ])
            ->recordActions([

                ActionGroup::make([

                    Action::make('edit')
                        ->label('Editar')
                        ->url(fn(SysCarrier $record): string => route('wsdadm.carriers.edit', [
                            'id' => $record->carrier_id
                        ])),

                    DeleteAction::make()
                        ->label('Excluir')
                        ->icon(null)
                        ->modalHeading("Excluir Transpordadora")
                        ->modalDescription("Deseja Excluir Essa Transpordadora?")
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Transpordadora Excluída')
                                ->body('Transpordadora foi excluida com sucesso'),
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
