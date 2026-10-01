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

use App\Models\SeoMetaTag;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Idea\Framework\Admin\Grids\Grid;
use Idea\Framework\Repository\Seo\SeoMetaTagRepository;

class SeoConfigGrid extends Grid
{

    protected string $heading = 'Gerenciamento de MetaTags para o SEO';
    protected string $primaryKey = 'seo_meta_tag_id';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(SeoMetaTagRepository::getData())
            ->heading($this->heading)
            ->columns([

                TextColumn::make('input_label')
                    ->label("Nome")
                    ->toggleable(false)
                    ->searchable(['name']),

                TextColumn::make('property')
                    ->label("Propriedade")
                    ->toggleable(false)
                    ->searchable(['property']),

                TextColumn::make('group')
                    ->label("Grupo")
                    ->toggleable(false)
                    ->searchable(['group']),

                TextColumn::make('default_value')
                    ->label("Valor Padrão")
                    ->toggleable(false)
                    ->searchable(['default_value']),

                TextColumn::make('status')
                    ->label("Status")
                    ->toggleable(false)
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->searchable(['status'])
                    ->color(fn(string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'warning',
                    })
                    ->formatStateUsing(function ($state) {
                        return ($state == 'active' ? 'Habilitado' : 'Desabilitado');
                    })
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

            ])
            ->recordActions([

                ActionGroup::make([

                    Action::make('edit')
                        ->label('Editar')
                        ->url(fn(SeoMetaTag $record): string => route('wsdadm.seo-config.edit', [
                            'id' => $record->seo_meta_tag_id
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
