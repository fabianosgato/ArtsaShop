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

use App\Models\SysModule;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Idea\Framework\Admin\Grids\Grid;

final class SysModuleGrid extends Grid
{

    public string $heading = 'Módulos do Sistema';
    public string $primaryKey = 'module_order';
    public string $sortDirection = 'ASC';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(SysModule::query())
            ->heading($this->heading)
            ->columns([
                TextColumn::make('module_name')
                    ->label("Módulo")
                    ->toggleable(false)
                    ->searchable(['module_name']),

                TextColumn::make('module_order')
                    ->label("Ordenação")
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->toggleable(false)
                    ->searchable(['module_name']),

                TextColumn::make('status')
                    ->label("Ativo")
                    ->toggleable(false)
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

                    // Edicao do Grupo
                    Action::make('edit')
                        ->label('Editar')
                        ->url(fn(SysModule $record): string => route('wsdadm.sysmodules.edit', [
                            'id' => $record->module_id
                        ])),

                    Action::make('sysmenus')
                        ->label('Menus do Sistema')
                        ->url(fn(SysModule $record): string => route('wsdadm.sysmenu', [
                            'moduleId' => $record->module_id
                        ])),

                    DeleteAction::make()
                        ->label('Excluir')
                        ->icon(null)
                        ->modalHeading("Excluir Módulo do sistema")
                        ->modalDescription("Deseja Excluir esse Módulo do sistema?")
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Módulo do sistema Excluído')
                                ->body('O Módulo do sistema foi excluido com sucesso'),
                        ),

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
