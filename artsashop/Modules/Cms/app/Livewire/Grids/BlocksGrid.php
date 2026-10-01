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


namespace Modules\Cms\Livewire\Grids;

use App\Models\CmsBlock;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Idea\Framework\Admin\Grids\Grid;
use Idea\Framework\Repository\Cms\CmsBlockRepository;
use Illuminate\Database\Eloquent\Builder;


class BlocksGrid extends Grid
{
    public string $heading = 'CMS: Blocos estaticos';
    public string $prefix = 'cmsBlocksGrid';
    public string $primaryKey = 'block_id';
    public string $sortField = 'block_id';
    public string $sortDirection = 'asc';

    public function datasource(): Builder
    {
        return CmsBlockRepository::getData();
    }

    public function table(Tables\Table $table): Tables\Table
    {

        return $table
            ->query($this->datasource())
            ->heading($this->heading)
            ->columns([

                TextColumn::make('block_id')
                    ->label("Id")
                    ->toggleable(false)
                    ->searchable(['block_id']),

                TextColumn::make('title')
                    ->label("Titulo da Block")
                    ->toggleable(false)
                    ->searchable(['title']),

                TextColumn::make('identifier')
                    ->label("KEY ")
                    ->toggleable(false)
                    ->searchable(['identifier']),

                TextColumn::make('updated_at')
                    ->label("Updated")
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->wrap()
                    ->toggleable(false)
                    ->dateTime('d/m/Y H:i:s'),

            ])
            ->recordActions([

                ActionGroup::make([

                    Action::make('edit')
                        ->label('Editar')
                        ->url(fn(CmsBlock $record): string => route('wsdadm.cms.blocks.edit', [
                            'id' => $record->block_id
                        ])),

                    DeleteAction::make()
                        ->label('Excluir')
                        ->icon(null)
                        ->modalHeading("Excluir Bloco")
                        ->modalDescription("Deseja Excluir Esse Bloco?")
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Bloco Excluído')
                                ->body('O Bloco foi excluido com sucesso'),
                        )
                ]),
            ])
            ->paginationPageOptions(
                options: $this->paginationPageOptions
            )
            ->striped()
            ->recordUrl(null)
            ->defaultSort($this->sortField, $this->sortDirection)
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession();


    }
}
