<?php

namespace Modules\Reports\Livewire\Grids;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Idea\Framework\Admin\Grids\Grid;
use Idea\Framework\Repository\Reports\ReportIncorrectWeightRepository;
use Idea\Framework\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Tapp\FilamentValueRangeFilter\Filters\ValueRangeFilter;


class ReportIncorrectWeightGrid extends Grid
{

    public function table(Tables\Table $table): Tables\Table
    {

        return $table
            ->query(ReportIncorrectWeightRepository::getData())
            ->heading('Logs do sistema')
            ->columns([

                Tables\Columns\ImageColumn::make('image_url')
                    ->label("")
                    ->width(80)
                    ->height(80)
                    ->extraImgAttributes(['loading' => 'lazy']),

                TextColumn::make('sku')
                    ->label("SKU")
                    ->toggleable()
                    ->searchable(['catalog_product.sku'])
                    ->extraHeaderAttributes([
                        'class' => 'w-4'
                    ]),

                TextColumn::make('name')
                    ->label("Produto")
                    ->description(fn(Model $record): string => "{$record->attribute_set_name}\n")
                    ->wrap()
                    ->toggleable()
                    ->searchable(['catalog_product.name'])
                    ->extraHeaderAttributes([
                        'class' => 'w-120'
                    ]),

                TextColumn::make('qty')
                    ->label( new HtmlString(nl2br("Estoque\ndo Produto")))
                    ->wrap()
                    ->toggleable()
                    ->alignCenter()
                    ->tooltip("Quantidade em estoque do Produto")
                    ->searchable(['catalog_product.qty'])
                    ->extraHeaderAttributes([
                        'class' => 'w-4'
                    ])
                    ->color('primary')
                    ->wrap(),

                TextColumn::make('weight')
                    ->label( new HtmlString(nl2br("Peso do\nProduto")))
                    ->wrap()
                    ->toggleable()
                    ->alignCenter()
                    ->searchable(['catalog_product.weight'])
                    ->tooltip("Peso do Produto")
                    ->formatStateUsing(function ($state) {
                        return  Utils::roundUp($state, 2)."Kg";
                    })
                    ->extraHeaderAttributes([
                        'class' => 'w-4'
                    ])
                    ->color('primary')
                    ->wrap(),

                TextColumn::make('mean_weight_default')
                    ->label( new HtmlString(nl2br("Média de Peso\n do Departamento")))
                    ->wrap()
                    ->toggleable()
                    ->tooltip("Média de Peso do Departamento")
                    ->searchable(['eav_attributes_set.mean_weight_default'])
                    ->extraHeaderAttributes([
                        'class' => 'w-4'
                    ])
                    ->alignCenter()
                    ->formatStateUsing(function ($state) {
                        return  Utils::roundUp($state, 2)."Kg";
                    })
                    ->color('danger')
                    ->wrap(),

                TextColumn::make('deviation_weight_default')
                    ->label( new HtmlString(nl2br("Desvio Padrão\ndo Departamento")))
                    ->wrap()
                    ->toggleable()
                    ->tooltip("Desvio Padrão de Peso do Departamento")
                    ->searchable(['eav_attributes_set.deviation_weight_default'])
                    ->extraHeaderAttributes([
                        'class' => 'w-4'
                    ])
                    ->alignCenter()
                    ->formatStateUsing(function ($state) {
                        return  Utils::roundUp($state, 2)."Kg";
                    })
                    ->color('danger')
                    ->wrap(),

                TextColumn::make('min_mean_weight')
                    ->label(new HtmlString(nl2br("Peso Médio\nMínimo")))
                    ->wrap()
                    ->toggleable()
                    ->searchable(['report_incorrect_weights.min_mean_weight'])
                    ->tooltip("Média Minima dos Pesos do Departamento: (Média de Peso Departamento - Desvio Padrão do Peso do Departamento)")
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ])
                    ->alignCenter()
                    ->formatStateUsing(function ($state) {
                        return  Utils::roundUp($state, 2)."Kg";
                    }),

                TextColumn::make('max_mean_weight')
                    ->label( new HtmlString(nl2br("Peso Médio\nMáximo")))
                    ->wrap()
                    ->toggleable()
                    ->searchable(['report_incorrect_weights.max_mean_weight'])
                    ->tooltip("Média Minima dos Pesos do Departamento: (Média de Peso Departamento + Desvio Padrão do Peso do Departamento)")
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ])
                    ->alignCenter()
                    ->formatStateUsing(function ($state) {
                        return  Utils::roundUp($state, 2)."Kg";
                    }),

                TextColumn::make('percentage_difference')
                    ->label( new HtmlString(nl2br("Diferença\nem porcentagem\nentre pesos")))
                    ->wrap()
                    ->toggleable()
                    ->searchable(['report_incorrect_weights.percentage_difference'])
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ])
                    ->tooltip("Esta porcentagem é calculada entre o PESO do Produto e o Peso Médio Mínimo")
                    ->alignCenter()
                    ->formatStateUsing(function ($state) {
                        return Utils::roundUp($state, 2)."%";
                    }),

                TextColumn::make('percentage_limit')
                    ->label( new HtmlString(nl2br("Porcentagem\nLimite\nUtilizada")))
                    ->wrap()
                    ->toggleable()
                    ->searchable(['report_incorrect_weights.percentage_limit'])
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ])
                    ->alignCenter()
                    ->tooltip("Limite da porcentagem para validar o Peso do produto")
                    ->formatStateUsing(function ($state) {
                        return  Utils::roundUp($state, 2)."%";
                    }),

                TextColumn::make('created_at')
                    ->label(new HtmlString(nl2br("Data de\nCriação")))
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->wrap()
                    ->toggleable()
                    ->dateTime('d/m/Y H:i:s')
                    ->extraHeaderAttributes([
                        'class' => 'w-8'
                    ])
                    ->alignCenter(),

            ])
            ->filters([
                // Filtra pelo KG do produto
                ValueRangeFilter::make('catalog_product.weight')
                    ->label("Filtrar por Kg")
                    ->columns(['catalog_product.weight']),

                // Filtra pelo estoque do produto
                ValueRangeFilter::make('catalog_product.qty')
                    ->label("Filtrar por Estoque")
                    ->columns(['catalog_product.qty'])

            ])
            ->actions([
                Tables\Actions\ActionGroup::make([

                    Tables\Actions\Action::make('edit')
                        ->label('Editar')
                        ->url(fn(Model $record): string => route('products.edit', [
                            'id' => $record->product_id
                        ])),
                    Tables\Actions\Action::make('view_info')
                        ->label('Visualizar informações')
                        ->action(
                            fn(Model $record) => $this->showView($record->product_id)
                        ),
                ])
            ])
            ->bulkActions([
                Tables\Actions\ActionGroup::make([
                    FilamentExportBulkAction::make('export')
                        ->label('Exportar')
                        ->fileNameFieldLabel('Nome do Arquivo')
                        ->csvDelimiter(';')
                        ->defaultFormat('csv')
                        ->disablePdf()
                        ->disableXlsx()
                        ->disablePreview(),
                    BulkActionGroup::make([
                        DeleteBulkAction::make(),
                    ]),
                ])->label('Ações'),
            ])
            ->paginationPageOptions([60, 90, 120, 140])
            ->striped()
            ->recordUrl(null)
            ->defaultSort('catalog_product.weight', 'asc')
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession();

    }

    public function getTableRecordKey(Model $record): string
    {
        return $record->product_id;
    }

    public function showView($rowId): void
    {
        $route = json_encode(['route' => route('products.show', ['id' => $rowId])]);
        $this->js('showLeft(' . $route . ')');
    }

}
