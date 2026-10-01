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

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Models\EavAttributesSet;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Idea\Framework\Admin\Grids\Grid;
use Idea\Framework\Repository\Eav\EavAttributeSetRepository;
use Illuminate\Database\Eloquent\Model;

final class EavAttributesSetGrid extends Grid
{

    public string $heading = 'Grupo de Atributos do Sistema';

    public string $prefix = 'EavAttributeSetGrid';
    public string $primaryKey = 'attribute_set_id';
    public string $sortField = 'attribute_set_name';
    public string $sortDirection = 'asc';

    public function table(Tables\Table $table): Tables\Table
    {

        return $table
            ->query(EavAttributeSetRepository::getData())
            ->heading($this->heading)
            ->columns([

                TextColumn::make('attribute_set_name')
                    ->label("Grupo de Atributos")
                    ->toggleable(false)
                    ->searchable(['eav_attributes_set.attribute_set_name']),

                TextColumn::make('attribute_set_key')
                    ->label("Key do Grupo")
                    ->toggleable(false)
                    ->searchable(['eav_attributes_set.attribute_set_key'])
                    ->extraHeaderAttributes([
                        'class' => 'w-12'
                    ]),

            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('edit')
                        ->label('Editar')
                        ->url(fn(EavAttributesSet $record): string => route('wsdadm.eav.attributeset.edit', [
                            'id' => $record->attribute_set_id
                        ])),
                    Action::make('attributes')
                        ->label('Atributos')
                        ->url(fn(EavAttributesSet $record): string => route('wsdadm.eav.attribute', [
                            'attributeSetId' => $record->attribute_set_id
                        ])),
                    Action::make('deleteall')
                        ->label('Excluir')
                        ->url(fn(EavAttributesSet $record): string => route('wsdadm.eav.attributeset.delete', [
                            'id' => $record->attribute_set_id
                        ])),

                ]),
            ])
            ->toolbarActions([
                FilamentExportBulkAction::make('export')
                    ->label('Exportar')
                    ->fileNameFieldLabel('Nome do Arquivo')
                    ->csvDelimiter(';')
                    ->defaultFormat('csv')
                    ->disablePdf()
                    ->disableXlsx()
            ])
            ->paginationPageOptions(
                options: $this->paginationPageOptions
            )
            ->striped()
            ->recordUrl(null)
            ->defaultSort(
                column: $this->sortField,
                direction: $this->sortDirection
            )
            ->persistColumnSearchesInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();



    }

    /**
     * Retorna a porcentagem do registro e formata a mesma
     * @param $percentage
     * @return string
     */
    private function getPercentage($percentage): string
    {
        if ($percentage > 0) {
            if ($percentage < 50) {
                return '<span class="badge bg-success" style="font-size: 0.98em">' . $percentage . '%</span>';
            } else {
                return '<span class="badge bg-danger" style="font-size: 0.98em">' . $percentage . '%</span>';
            }

        } else {
            return '<span class="badge bg-success" style="font-size: 0.98em">' . $percentage . '%</span>';
        }
    }

    /**
     * Retorna o total de produtos de cada Grupo de Atributos
     * @param Model $row
     * @return string
     */
    private function getTotalsLabel(Model $row): string
    {
        if ($row->product_qty_enable > $row->product_qty_disable) {
            return '<span class="text-success" style="font-size: 1em"><strong>' . $row->product_qty . '</strong></span>';
        } else {
            return '<span class="text-danger" style="font-size: 1em"><strong>' . $row->product_qty . '</strong></span>';
        }
    }

}
