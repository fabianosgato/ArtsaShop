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

use App\Models\SysGroup;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Idea\Framework\Admin\Grids\Grid;

final class SysGroupGrid extends Grid
{

    protected string $heading = 'Grupos do sistema';
    public string $primaryKey = 'group_id';
    public string $sortDirection = 'desc';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(SysGroup::query())
            ->heading($this->heading)
            ->columns([
                TextColumn::make('group_name')
                    ->label("Grupo")
                    ->toggleable(false)
                    ->searchable(['group_name']),

                TextColumn::make('status')
                    ->label("Ativo")
                    ->toggleable(false)
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->searchable(['sys_users.status'])
                    ->color(fn(string $state): string => match ($state) {
                        '1' => 'success',
                        '0' => 'warning',
                    })
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
                        ->url(fn(SysGroup $record): string => route('wsdadm.sysgroups.edit', [
                            'id' => $record->group_id
                        ])),

                    DeleteAction::make()
                        ->label('Excluir')
                        ->icon(null)
                        ->modalHeading("Excluir Grupo de Usuário")
                        ->modalDescription("Deseja Excluir esse Grupo de Usuário?")
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Grupo de Usuário Excluído')
                                ->body('O Grupo de Usuário foi excluido com sucesso'),
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
            ->searchable(false)
            ->persistFiltersInSession();

    }

}
