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

namespace Modules\Eav\Livewire\Grids;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Idea\Framework\Admin\Grids\Grid;
use Idea\Framework\Repository\Eav\EavAttributesRepository;
use Illuminate\Database\Eloquent\Model;
use Modules\Eav\Enums\FrontendInputType;

final class EavAttributeGrid extends Grid
{

    public ?string $attributeSetId;
    public string $heading = 'Atributos do Sistema';
    public string $primaryKey = 'eav_attributes.attribute_id';
    public string $sortDirection = 'desc';

    public function table(Tables\Table $table): Tables\Table
    {

        return $table
            ->query(EavAttributesRepository::getAttributesBySetId(
                attributeSetId: $this->attributeSetId,
                isVisible: false
            ))
            ->heading('Atributos do sistema')
            ->columns([

                TextColumn::make('attribute_id')
                    ->label("Id")
                    ->toggleable(false)
                    ->searchable(['eav_attributes.attribute_id'])
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

                TextColumn::make('attribute_code')
                    ->label("Código do Atributo")
                    ->toggleable(false)
                    ->searchable(['eav_attributes.attribute_code'])
                    ->extraHeaderAttributes([
                        'class' => 'w-20'
                    ]),

                TextColumn::make('attribute_label')
                    ->label("Nome do Atributo")
                    ->toggleable(false)
                    ->searchable(['eav_attributes.attribute_label']),

                TextColumn::make('frontend_input')
                    ->label("Tipo do Campo")
                    ->toggleable(false)
                    ->extraHeaderAttributes([
                        'class' => 'w-20'
                    ]),

                TextColumn::make('is_system')
                    ->label("Sistema")
                    ->toggleable(false)
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->searchable(false)
                    ->formatStateUsing(function ($state) {
                        return (boolval($state) ? 'Sim' : 'Não');
                    })
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

                TextColumn::make('is_required')
                    ->label("Requerido")
                    ->toggleable(false)
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->searchable(false)
                    ->formatStateUsing(function ($state) {
                        return (boolval($state) ? 'Sim' : 'Não');
                    })
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

                TextColumn::make('is_visible')
                    ->label("Visível no Frontend")
                    ->toggleable(false)
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->searchable(false)
                    ->formatStateUsing(function ($state) {
                        return (boolval($state) ? 'Sim' : 'Não');
                    })
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ]),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('eav_attributes.is_system')
                    ->label('Atributo de Sistema')
                    ->options([
                        1 => 'Sim',
                        0 => 'Não'
                    ])
                    ->attribute('eav_attributes.is_system'),

                Tables\Filters\SelectFilter::make('eav_entity_attribute.frontend_input')
                    ->label('Tipo do Campo')
                    ->options(FrontendInputType::options())
                    ->searchable()
                    ->preload()
                    ->attribute('eav_entity_attribute.frontend_input')

            ])
            ->recordActions([

                ActionGroup::make([

                    Action::make('edit')
                        ->label('Editar')
                        ->url(fn(Model $record): string => route('wsdadm.eav.attribute.edit', [
                            'attributeSetId' => $record->attribute_set_id,
                            'id' => $record->attribute_id
                        ])),

                    Action::make('edit')
                        ->label('Excluir')
                        ->url(fn(Model $record): string => route('wsdadm.eav.attribute.delete', [
                            'attributeSetId' => $record->attribute_set_id,
                            'id' => $record->attribute_id
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
            ->persistColumnSearchesInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();

    }

}
