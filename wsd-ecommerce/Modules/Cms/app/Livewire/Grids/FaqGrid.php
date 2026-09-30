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

use App\Models\CmsFaq;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Idea\Framework\Admin\Grids\Grid;
use Idea\Framework\Repository\Cms\CmsFaqRepository;

class FaqGrid extends Grid
{

    public string $heading = 'Faq - perguntas e respostas';
    public string $prefix = 'cmsFaqGrid';
    public string $primaryKey = 'faq_id';
    public string $sortField = 'sort_order';
    public string $sortDirection = 'asc';

    public function table(Table $table): Table
    {

        return $table
            ->query(CmsFaqRepository::getData())
            ->heading($this->heading)
            ->columns([

                TextColumn::make('faq_title')
                    ->label("Titulo/Pergunta")
                    ->toggleable(false)
                    ->searchable(['faq_title']),

                TextColumn::make('sort_order')
                    ->label("Ordenação")
                    ->toggleable(false)
                    ->searchable(false),

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
                        ->url(fn(CmsFaq $record): string => route('wsdadm.cms.faq.edit', [
                            'id' => $record->faq_id
                        ])),

                    DeleteAction::make()
                        ->label('Excluir')
                        ->icon(null)
                        ->modalHeading("Excluir Página")
                        ->modalDescription("Deseja Excluir Essa Faq?")
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('FAQ Excluída')
                                ->body('A FAQ foi excluida com sucesso'),
                        )
                ]),
            ])
            ->paginationPageOptions(
                options: $this->paginationPageOptions
            )
            ->reorderable('sort_order')
            ->striped()
            ->recordUrl(null)
            ->defaultSort($this->sortField, $this->sortDirection)
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession();


    }

}
