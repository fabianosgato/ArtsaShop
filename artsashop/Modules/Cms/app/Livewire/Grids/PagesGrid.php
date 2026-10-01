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

use App\Models\CmsPage;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Idea\Framework\Admin\Grids\Grid;
use Idea\Framework\Repository\Cms\CmsPageRepository;

class PagesGrid extends Grid
{
    public string $heading = 'Páginas';
    public string $prefix = 'cmsPageGrid';
    public string $primaryKey = 'page_id';
    public string $sortField = 'page_id';
    public string $sortDirection = 'asc';

    public function table(Tables\Table $table): Tables\Table
    {

        return $table
            ->query(CmsPageRepository::getData())
            ->heading($this->heading)
            ->columns([

                TextColumn::make('title')
                    ->label("Titulo da Pagina")
                    ->toggleable(false)
                    ->searchable(['title']),

                TextColumn::make('slug_key')
                    ->label("URL")
                    ->toggleable(false)
                    ->searchable(['slug_key'])
                    ->extraHeaderAttributes([
                        'class' => 'w-12'
                    ]),

                TextColumn::make('updated_at')
                    ->label("Atualizado em")
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->wrap()
                    ->toggleable(false)
                    ->dateTime('d/m/Y H:i:s')
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

            ])
            ->recordActions([
                ActionGroup::make([

                    Action::make('edit')
                        ->label('Editar')
                        ->url(fn(CmsPage $record): string => route('wsdadm.cms.pages.edit', [
                            'id' => $record->page_id
                        ])),

                    DeleteAction::make()
                        ->label('Excluir')
                        ->icon(null)
                        ->modalHeading("Excluir Página")
                        ->modalDescription("Deseja Excluir Essa Página?")
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Página Excluída')
                                ->body('Página foi excluida com sucesso'),
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
