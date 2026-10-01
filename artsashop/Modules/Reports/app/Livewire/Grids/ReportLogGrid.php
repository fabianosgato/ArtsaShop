<?php
/**
 * Lef Tecnologia
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

namespace Modules\Reports\Livewire\Grids;

use App\Models\SysLog;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Idea\Framework\Admin\Grids\Grid;
use Idea\Framework\Repository\Logs\SysLogsRepository;
use Illuminate\Support\HtmlString;

class ReportLogGrid extends Grid
{


    public function table(Tables\Table $table): Tables\Table
    {

        return $table
            ->query(SysLogsRepository::getData())
            ->heading('Logs do sistema')
            ->columns([

                TextColumn::make('entity_id')
                    ->label("Id")
                    ->toggleable()
                    ->searchable(['entity_id'])
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

                TextColumn::make('module')
                    ->label("Módulo")
                    ->toggleable()
                    ->searchable(['module'])
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

                TextColumn::make('type')
                    ->label("Tipo")
                    ->wrap()
                    ->toggleable()
                    ->searchable(['type'])
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

                TextColumn::make('log')
                    ->label("Mensagem")
                    ->wrap()
                    ->toggleable()
                    ->formatStateUsing(fn(string $state): HtmlString => new HtmlString(nl2br($state)))
                    ->searchable(['log']),

                TextColumn::make('created')
                    ->label("Data do Log")
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->wrap()
                    ->toggleable()
                    ->dateTime('d/m/Y H:i:s')
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

            ])
            ->filters([
                // Filtro para o status do produto
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipo de erro')
                    ->options(SysLog::query()->groupBy(['type'])->pluck('type', 'type'))
                    ->searchable()
                    ->preload()
                    ->attribute('type'),

                // Filtro para o status do produto
                Tables\Filters\SelectFilter::make('module')
                    ->label('Módulo')
                    ->options(SysLog::query()->groupBy(['module'])->pluck('module', 'module'))
                    ->searchable()
                    ->preload()
                    ->attribute('module'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->paginationPageOptions([30, 60, 90, 120])
            ->striped()
            ->recordUrl(null)
            ->defaultSort('created', 'desc')
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession();

    }


}
