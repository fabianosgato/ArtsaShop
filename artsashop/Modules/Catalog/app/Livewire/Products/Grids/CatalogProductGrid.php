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

namespace Modules\Catalog\Livewire\Products\Grids;

// use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Models\CatalogProductBrand;
use App\Models\CatalogProductStatus;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Idea\Framework\Admin\Grids\Grid;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Repository\Eav\EavAttributeSetRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

final class CatalogProductGrid extends Grid
{

    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Tables\Table $table): Tables\Table
    {

        return $table
            ->query(CatalogProductsRepository::getData())
            ->heading('Produtos Cadastrados')
            ->columns([

                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('')
                    ->width(80)
                    ->toggleable(false)
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->extraHeaderAttributes([
                        'class' => 'adm-wd-30'
                    ]),

                TextColumn::make('sku')
                    ->label("SKU")
                    ->toggleable(false)
                    ->searchable(['catalog_product.sku'])
                    ->extraHeaderAttributes([
                        'class' => 'adm-wd-40'
                    ]),

                TextColumn::make('name')
                    ->label("Produto")
                    ->toggleable(false)
                    ->wrap()
                    ->description(
                        fn(Model $record): HtmlString => new HtmlString("<strong>Grupo de Atributos</strong>: $record->attribute_set_name")
                    )
                    ->searchable(['catalog_product.name'])
                    ->formatStateUsing(fn(string $state): HtmlString => new HtmlString($state))
                    ->markdown()
                    ->html(),

                TextColumn::make('weight')
                    ->label("Peso")
                    ->toggleable(false)
                    ->numeric()
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->formatStateUsing(function ($state) {
                        return "{$state} Kg";
                    })
                    ->extraHeaderAttributes([
                        'class' => 'adm-wd-40'
                    ]),

                TextColumn::make('qty')
                    ->label("Qty")
                    ->toggleable(false)
                    ->numeric()
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->extraHeaderAttributes([
                        'class' => 'adm-wd-40'
                    ]),

                TextColumn::make('final_price')
                    ->label("Preço Final")
                    ->numeric()
                    ->verticallyAlignCenter()
                    ->toggleable(false)
                    ->alignCenter()
                    ->formatStateUsing(function ($state) {
                        return formatPrice($state);
                    })
                    ->extraHeaderAttributes([
                        'class' => 'adm-wd-50'
                    ]),

                TextColumn::make('catalog_product_status.status')
                    ->label("Status")
                    ->wrap()
                    ->toggleable(false)
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->searchable(false)
                    ->extraHeaderAttributes([
                        'class' => 'adm-wd-30'
                    ]),

                TextColumn::make('updated_at')
                    ->label("Atualizado em")
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->wrap()
                    ->toggleable(false)
                    ->dateTime('d/m/Y H:i:s')
                    ->extraHeaderAttributes([
                        'class' => 'adm-wd-30'
                    ]),
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
                            ->pluck('brand_name', 'brand_id')
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

            ])
            ->recordActions([

                ActionGroup::make([

                    Action::make('edit')
                        ->label('Editar')
                        ->url(fn(Model $record): string => route('wsdadm.catalog.products.edit', [
                            'id' => $record->product_id
                        ])),

                    DeleteAction::make()
                        ->label('Excluir')
                        ->icon(null)
                        ->modalHeading("Excluir do Produto")
                        ->modalDescription("Deseja Excluir esse Produto")
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Produto Excluído')
                                ->body('Produto Excluído com sucesso')
                        ),

                    Action::make('view_info')
                        ->label('Visualizar informações')
                        ->action(
                            fn(Model $record) => $this->showView($record->product_id)
                        ),

                ])
            ])
            ->toolbarActions([

                BulkActionGroup::make([

                    BulkAction::make('updateAttributeSets')
                        ->label("Alterar Grupo de Atributos")
                        ->icon('heroicon-o-check-badge')
                        ->form([
                            Select::make('attribute_set_id')
                                ->label('Grupo de Atributos')
                                ->options(EavAttributeSetRepository::getAttibuteSetOptions())
                                ->required()
                                ->searchable()
                        ])
                        ->action(function (Collection $records, array $data): void {
                            foreach ($records as $record) {
                                CatalogProductsRepository::updateAttributeSet(
                                    productId: $record->product_id,
                                    attributeSetId: $data['attribute_set_id']
                                );
                            }
                        }),

                    BulkAction::make('updateBrands')
                        ->label("Alterar Marca")
                        ->icon('heroicon-o-tag')
                        ->form([
                            Select::make('brand_id')
                                ->label('Marcas')
                                ->options(CatalogProductBrand::query()->pluck('brand_name', 'brand_id'))
                                ->required()
                                ->searchable()
                        ]),

                    // Acao de Exluir os produtos em Massa
                    BulkAction::make('deleteProducts')
                        ->label("Excluir Produtos")
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->modalHeading("Você deseja excluir esses produtos?")
                        ->deselectRecordsAfterCompletion()
                        ->successNotification(
                            Notification::make()->success()
                                ->title('Sucesso !!!')
                                ->body('Produtos Excluídos com Sucesso')
                        )
                        ->action(function (Collection $records, array $data): void {
                            foreach ($records as $record) {
                                \Modules\Catalog\Services\CatalogProductService::deleteProduct(
                                    productId: $record->product_id
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

    public function showView($rowId): void
    {
        $route = json_encode([
            'route' => route('wsdadm.catalog.products.show', ['id' => $rowId])
        ]);

        $this->js('window.showLeft(' . $route . ')');
    }

}
