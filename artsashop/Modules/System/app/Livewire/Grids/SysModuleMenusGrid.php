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

use App\Models\SysModulesMenu;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Idea\Framework\Admin\Grids\Grid;
use Illuminate\Database\Eloquent\Builder;

final class SysModuleMenusGrid extends Grid
{

    public ?string $moduleId;
    protected string $heading = 'Menu do sistema';
    protected string $primaryKey = 'menu_order';
    public string $sortDirection = 'asc';

    public function datasource(): Builder
    {
        return SysModulesMenu::query()->where(
            column: 'module_id',
            operator: '=',
            value: $this->moduleId
        );
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query($this->datasource())
            ->heading($this->heading)
            ->columns([

                TextColumn::make('menu_name')
                    ->label("Acesso")
                    ->toggleable(false)
                    ->searchable(['menu_name']),

                TextColumn::make('menu_link')
                    ->label("Rota")
                    ->toggleable(false)
                    ->searchable(['menu_link'])
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

                TextColumn::make('menu_order')
                    ->label("Ordenação")
                    ->toggleable(false)
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

                TextColumn::make('is_visible')
                    ->label("Visivel")
                    ->toggleable(false)
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->searchable(['sys_modules_menus.is_visible'])
                    ->formatStateUsing(function ($state) {
                        return ($state == 1 ? 'Sim' : 'Não');
                    })
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

                // Exemplo de Status
                TextColumn::make('status')
                    ->label("Ativo")
                    ->toggleable(false)
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->searchable(['sys_modules_menus.status'])
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
                        ->url(fn(SysModulesMenu $record): string => route('wsdadm.sysmenu.edit', [
                            'moduleId' => $record->module_id,
                            'id' => $record->module_menu_id
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
            ->persistFiltersInSession()
            ->searchable(false);

    }

}
