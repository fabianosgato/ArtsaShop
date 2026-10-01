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

namespace Modules\Sales\Livewire\Grid;

use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Models\SalesOrder;
use App\Models\SalesOrderStatus;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Idea\Framework\Admin\Grids\Grid;
use Idea\Framework\Admin\SystemConfig;
use Idea\Framework\Repository\Sales\SalesOrderRepository;
use Idea\Framework\Utils;
use Illuminate\Support\Facades\Cache;

class SalesOrderGrid extends Grid
{

    public function table(Tables\Table $table): Tables\Table
    {

        return $table
            ->query(SalesOrderRepository::getData())
            ->heading('Pedidos')
            ->columns([

                TextColumn::make('increment_code')
                    ->label("Pedido #")
                    ->toggleable()
                    ->searchable(['sales_order_code.increment_code'])
                    ->extraHeaderAttributes([
                        'class' => 'adm-wd-30'
                    ]),

                TextColumn::make('label')
                    ->label("Status")
                    ->toggleable()
                    ->searchable(['sales_order_status.label'])
                    ->wrap()
                    ->extraHeaderAttributes([
                        'style' => 'width:7em'
                    ]),

                TextColumn::make('customer_name')
                    ->label("Cliente")
                    ->wrap()
                    ->toggleable()
                    ->searchable(['customer_entity.customer_name'])
                    ->extraHeaderAttributes([
                        'class' => 'adm-wd-180'
                    ]),

                TextColumn::make('customer_document')
                    ->label("CPF/CNPJ")
                    ->wrap()
                    ->toggleable()
                    ->searchable(['customer_entity.vat_number'])
                    ->extraHeaderAttributes([
                        'style' => 'width:150px'
                    ])
                    ->formatStateUsing(function ($state) {
                        return Utils::formatCustomerDocument($state);
                    }),

                TextColumn::make('payment_amount')
                    ->label("Valor Pedido")
                    ->numeric()
                    ->verticallyAlignCenter()
                    ->toggleable()
                    ->alignCenter()
                    ->formatStateUsing(function ($state) {
                        return number_format($state, 2, '.', '');
                    })
                    ->extraHeaderAttributes([
                        'class' => 'adm-wd-60'
                    ]),

                TextColumn::make('sales_order_payments.description')
                    ->label("Pagamento")
                    ->toggleable()
                    ->wrap()
                    ->searchable(['sales_order_payments.description'])
                    ->extraHeaderAttributes([
                        'class' => 'adm-wd-60'
                    ]),

                TextColumn::make('created_at')
                    ->label("Data Pedido")
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->wrap()
                    ->toggleable()
                    ->dateTime('m/d/y')
                    ->extraHeaderAttributes([
                        'class' => 'adm-wd-60'
                    ]),

            ])
            ->filters([

                // Filtro para o status do Pedido
                Tables\Filters\SelectFilter::make('sales_orders.status_id')
                    ->label('Status do Pedido')
                    ->options(
                        Cache::remember("admin_filter_sales_order_status", (3600 * 24), function () {
                            return SalesOrderStatus::query()
                                ->where('is_enabled', '=', true)
                                ->orderBy('ordination')
                                ->pluck('label', 'status_id');
                        })
                    )
                    ->searchable()
                    ->preload()
                    ->attribute('sales_orders.status_id'),

            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('view')
                        ->label('Detalhes')
                        ->url(fn(SalesOrder $record): string => route('wsdadm.orders.view', [
                            'id' => $record->order_id
                        ])),

                    Action::make('view_info')
                        ->label('Informação Rápida')
                        ->action(fn(SalesOrder $record) => $this->showView($record->order_id)),
                ])
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
            ->recordClasses(fn(SalesOrder $record) => match ($record->status) {
                'complete' => 'adm-bg-complete',
                'approved' => 'adm-bg-approved',
                'shipped' => SystemConfig::setColorOrder($record),
                'returned' => 'adm-bg-returned',
                'refunded' => 'adm-bg-refunded',
                'canceled_marketplace' => 'adm-bg-red-50',
                'product_returned' => 'bg-red-200',
                'product_returned_damage' => 'bg-red-100',
                default => 'bg-red-200',
            })
            ->recordUrl(null)
            ->defaultSort(
                column: 'sales_orders.created_at',
                direction: 'desc'
            )
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession();

    }

    public function showView($rowId): void
    {
        $route = json_encode([
            'route' => route('wsdadm.orders.show', ['id' => $rowId])
        ]);
        $this->js('showLeft(' . $route . ')');
    }

}
