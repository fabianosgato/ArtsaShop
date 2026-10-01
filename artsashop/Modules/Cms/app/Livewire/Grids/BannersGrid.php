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

use App\Models\CmsBanner;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Idea\Framework\Admin\Grids\Grid;
use Idea\Framework\Repository\Cms\CmsBannerRepository;
use Illuminate\Database\Eloquent\Builder;

class BannersGrid extends Grid
{

    public string $heading = 'CMS: Banners';
    public string $prefix = 'cmsBannerGrid';
    public string $primaryKey = 'banner_id';
    public string $sortField = 'banner_id';
    public string $sortDirection = 'desc';

    public function datasource(): Builder
    {
        return CmsBannerRepository::getData();
    }

    public function table(Tables\Table $table): Tables\Table
    {

        return $table
            ->query($this->datasource())
            ->heading($this->heading)
            ->columns([

                TextColumn::make('banner_id')
                    ->label("Id")
                    ->toggleable()
                    ->searchable(['banner_id']),

                TextColumn::make('title')
                    ->label("Titulo do Banner")
                    ->toggleable()
                    ->searchable(['title']),

                TextColumn::make('banner_url')
                    ->label("URL")
                    ->toggleable()
                    ->searchable(['banner_url']),

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
                        ->url(fn(CmsBanner $record): string => route('wsdadm.cms.banners.edit', [
                            'id' => $record->banner_id
                        ])),

                    DeleteAction::make()
                        ->label('Excluir')
                        ->icon(null)
                        ->modalHeading("Excluir Banner")
                        ->modalDescription("Deseja Excluir Essa Banner?")
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Banner Excluído')
                                ->body('Banner foi excluido com sucesso'),
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
