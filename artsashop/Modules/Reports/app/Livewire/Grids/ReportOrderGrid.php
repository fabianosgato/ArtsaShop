<?php
/**
 * Lef Tecnologia
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

use App\Models\Marketplace;
use App\Models\SalesOrder;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Idea\Framework\Admin\Grids\Grid;
use Idea\Framework\Repository\Sales\SalesOrderRepository;
use Idea\Framework\Utils;
use Illuminate\Database\Eloquent\Model;

class ReportOrderGrid extends Grid
{

    public function table(Tables\Table $table): Tables\Table
    {

        return $table
            ->query(SalesOrderRepository::getReportOrder())
            ->heading('TODOS OS PEDIDOS NÃO APROVADOS')
            ->columns([

                TextColumn::make('canal_remote_id')
                    ->label("Id do Canal")
                    ->toggleable()
                    ->searchable(['sales_orders.canal_remote_id'])
                    ->extraHeaderAttributes([
                        'style' => 'width:20px'
                    ]),

                TextColumn::make('label')
                    ->label("Status")
                    ->toggleable()
                    ->searchable(['sales_order_status.label'])
                    ->extraHeaderAttributes([
                        'style' => 'width: 20px'
                    ]),

                TextColumn::make('canal')
                    ->label("Canal")
                    ->toggleable()
                    ->searchable(['sales_orders.canal'])
                    ->extraHeaderAttributes([
                        'style' => 'width: 20px'
                    ]),

                TextColumn::make('customer_name')
                    ->label("Cliente")
                    ->wrap()
                    ->toggleable()
                    ->searchable(['customer_entity.customer_name'])
                    ->extraHeaderAttributes([
                        'style' => 'width: 260px'
                    ]),

                TextColumn::make('customer_document')
                    ->label("Documento")
                    ->wrap()
                    ->toggleable()
                    ->searchable(['customer_entity.vat_number'])
                    ->extraHeaderAttributes([
                        'style' => 'width:150px'
                    ])
                    ->formatStateUsing(function ($state) {
                        return Utils::formatCustomerDocument($state);
                    }),

                TextColumn::make('product_names')
                    ->label("Produto(s)")
                    ->description(fn(Model $record): string => "(Itens comprados: " . intval($record->total_qty_ordered) . ")")
                    ->wrap()
                    ->toggleable()
                    ->searchable(false)
                    ->extraHeaderAttributes([
                        'style' => 'width:auto'
                    ])
                    ->formatStateUsing(function ($state) {
                        return nl2br($state);
                    })
                    ->html(),

                TextColumn::make('order_price')
                    ->label("Valor Pedido")
                    ->numeric()
                    ->verticallyAlignCenter()
                    ->toggleable()
                    ->alignCenter()
                    ->formatStateUsing(function ($state) {
                        $fmt = new \NumberFormatter('pt_BR', \NumberFormatter::CURRENCY);
                        return "{$state}\n";
                    })
                    ->extraHeaderAttributes([
                        'style' => 'width: 20px'
                    ]),

                TextColumn::make('titulo_marketplaces')
                    ->label("Marketplace")
                    ->toggleable()
                    ->searchable(['marketplaces.titulo_marketplaces'])
                    ->extraHeaderAttributes([
                        'style' => 'width: 20px'
                    ]),

                TextColumn::make('created')
                    ->label("Data Pedido")
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->wrap()
                    ->toggleable()
                    ->dateTime('d/m/Y H:i:s')
                    ->extraHeaderAttributes([
                        'style' => 'width: 20px'
                    ]),

            ])
            ->filters([

                // Filtro para o status do produto
                Tables\Filters\SelectFilter::make('marketplaces.marketplace_id')
                    ->label('Marketplace')
                    ->options(Marketplace::query()->where('status', '=', true)->pluck('titulo_marketplaces', 'marketplace_id')->toArray())
                    ->searchable()
                    ->preload()
                    ->attribute('marketplaces.marketplace_id'),

                // Filtro para o status do produto
                Tables\Filters\SelectFilter::make('sales_orders.canal')
                    ->label('Canal')
                    ->options(
                        SalesOrder::query()->groupBy(['canal'])->pluck('canal', 'canal')->toArray()
                    )
                    ->searchable()
                    ->preload()
                    ->attribute('sales_orders.canal'),

                Tables\Filters\Filter::make('customer_entity.customer_name')
                    ->label("Cliente"),

                Tables\Filters\Filter::make('customer_entity.vat_number')
                    ->label("N. Documento"),

                Tables\Filters\Filter::make('sales_order_item.product_name')
                    ->label("Produto"),

                Tables\Filters\Filter::make('sales_order_item.product_sku')
                    ->label("SKU"),

                Tables\Filters\Filter::make('sales_orders.canal_remote_id')
                    ->label("ID do Canal"),

            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('view')
                        ->label('Detalhes')
                        ->url(fn(SalesOrder $record): string => route('reports.orders-view', [
                            'id' => $record->order_id
                        ]))
                ])
            ])
            ->paginationPageOptions([30, 60, 90, 120])
            ->striped()
            ->recordUrl(null)
            ->defaultSort('sales_orders.order_id', 'desc')
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession();

    }

}
