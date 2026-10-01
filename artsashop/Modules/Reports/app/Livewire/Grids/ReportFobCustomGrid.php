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
namespace Modules\Reports\Livewire\Grids;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Models\CatalogProductBrand;
use App\Models\CatalogProductStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Idea\Framework\Admin\Grids\Grid;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Repository\Eav\EavAttributeSetRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

final class ReportFobCustomGrid extends Grid
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Tables\Table $table): Tables\Table
    {

        return $table
            ->query(CatalogProductsRepository::getByCustomFob())
            ->heading('Produtos Com FOB FIXO')
            ->columns([

                Tables\Columns\ImageColumn::make('image_url')
                    ->width(80)
                    ->height(80)
                    ->extraImgAttributes(['loading' => 'lazy']),

                TextColumn::make('sku')
                    ->label("SKU")
                    ->toggleable()
                    ->searchable(['catalog_product.sku']),

                TextColumn::make('ean')
                    ->label("EAN")
                    ->toggleable()
                    ->visible()
                    ->searchable(['catalog_product.ean']),

                TextColumn::make('attribute_set_name')
                    ->label("Grupo de Atributos")
                    ->wrap()
                    ->toggleable()
                    ->searchable(['eav_attributes_set.attribute_set_name']),

                TextColumn::make('name')
                    ->label("Produto")
                    ->description(fn(Model $record): string => "Status: {$record->availability_status}, Ean: {$record->ean}\n"
                    )
                    ->wrap()
                    ->toggleable()
                    ->searchable(['catalog_product.name', 'catalog_product.ean'])
                    ->formatStateUsing(fn(string $state): HtmlString => new HtmlString($state))
                    ->markdown(),

                TextColumn::make('weight')
                    ->label("Peso")
                    ->numeric()
                    ->verticallyAlignCenter()
                    ->toggleable()
                    ->alignCenter()
                    ->formatStateUsing(function ($state) {
                        return "{$state} Kg";
                    }),

                TextColumn::make('qty')
                    ->label("Qty")
                    ->numeric()
                    ->verticallyAlignCenter()
                    ->toggleable()
                    ->alignCenter(),

                TextColumn::make('price')
                    ->label("FOB")
                    ->numeric()
                    ->verticallyAlignCenter()
                    ->toggleable()
                    ->alignCenter()
                    ->formatStateUsing(function ($state) {
                        $fmt = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
                        return $fmt->formatCurrency($state, "USD") . "\n";
                    })
                    ->color('primary'),

                TextColumn::make('price_custom')
                    ->label("FOB Personalizado")
                    ->numeric()
                    ->verticallyAlignCenter()
                    ->toggleable()
                    ->alignCenter()
                    ->formatStateUsing(function ($state) {
                        $fmt = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
                        return $fmt->formatCurrency($state, "USD") . "\n";
                    })
                    ->color('danger'),

                TextColumn::make('updated')
                    ->label("Atualizado em")
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->wrap()
                    ->toggleable()
                    ->dateTime('d/m/Y H:i:s')
                    ->dateTimeTooltip(),
            ])
            ->filters([

                // Filtro para o Grupo de Atributos
                Tables\Filters\SelectFilter::make('eav_attributes_set.attribute_set_name')
                    ->label('Grupo de Atributos')
                    ->options(EavAttributeSetRepository::getOptionsData())
                    ->getSearchResultsUsing(fn(string $search): array => (
                    EavAttributeSetRepository::getOptionsData($search)
                    ))
                    ->searchable()
                    ->preload()
                    ->attribute('catalog_product.attribute_set_id'),

                // Filtro para o status do produto
                Tables\Filters\SelectFilter::make('catalog_product.brand')
                    ->label('Marca do produto')
                    ->options(
                        CatalogProductBrand::query()
                            ->orderBy('brand_name')
                            ->pluck('brand_name', 'entity_id')
                            ->toArray()
                    )
                    ->searchable()
                    ->preload()
                    ->attribute('catalog_product.brand_id'),


                // Filtro para o status do produto
                Tables\Filters\SelectFilter::make('catalog_product_status.status')
                    ->label('Status do produto')
                    ->options(CatalogProductStatus::query()->pluck('status', 'status_id')->toArray())
                    ->searchable()
                    ->preload()
                    ->attribute('catalog_product_status.status_id'),

                Tables\Filters\SelectFilter::make('amazon_products.is_excluded')->label('Excluido')
                    ->options([
                        1 => 'Sim',
                        0 => 'Não'
                    ])
                    ->attribute('amazon_products.is_excluded'),

                Tables\Filters\Filter::make('catalog_product.sku')
                    ->label("SKU do Middleware"),

                Tables\Filters\Filter::make('catalog_product.name')
                    ->label("Produto"),

            ])
            ->actions([
                Tables\Actions\ActionGroup::make([

                    Tables\Actions\Action::make('edit')
                        ->label('Editar')
                        ->url(fn(Model $record): string => route('products.edit', [
                            'id' => $record->product_id
                        ])),

                    Tables\Actions\Action::make('report_prices')
                        ->label('Histórico de Preços')
                        ->url(fn(Model $record): string => route('products.reportPrices', [
                            'id' => $record->product_id
                        ])),

                    Tables\Actions\Action::make('view_info')
                        ->label('Visualizar informações')
                        ->action(
                            fn(Model $record) => $this->showView($record->product_id)
                        ),

                    // Action para atualizar as informacoes de um produto na API do Middleware
                    Tables\Actions\Action::make('update_product')
                        ->label('Atualizar Produto')
                        ->action(
                            fn(Model $record) => $this->updateProduct(
                                asin: $record->asin,
                                redirectTo: '/catalog/products'
                            )
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

                    Tables\Actions\BulkAction::make('updateAttributeSets')
                        ->label("Alterar Grupo de Atributos")
                        ->icon('heroicon-o-check-badge')
                        ->form([
                            Select::make('attribute_set_id')
                                ->label('Grupo de Atributos')
                                ->options(EavAttributeSetRepository::getAttibuteSetOptions())
                                ->required()
                                ->searchable()
                        ]),

                    Tables\Actions\BulkAction::make('updateBrands')
                        ->label("Alterar Marca")
                        ->icon('heroicon-o-tag')
                        ->form([
                            Select::make('brand_id')
                                ->label('Marcas')
                                ->options(CatalogProductBrand::query()->pluck('brand_name', 'entity_id'))
                                ->required()
                                ->searchable()
                        ])
                        ->action(function (Collection $records, array $data): void {
                            foreach ($records as $record) {
                                \Modules\Catalog\Services\CatalogProductService::updateBrands(
                                    productId: $record->product_id,
                                    brandId: $data['brand_id']
                                );
                            }
                        }),

                ])->label('Ações')


            ])
            ->paginationPageOptions([30, 60, 90, 120])
            ->striped()
            ->recordUrl(null)
            ->defaultSort('catalog_product.product_id', 'desc')
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
