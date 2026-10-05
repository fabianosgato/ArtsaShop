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
namespace Modules\SalesRules\Livewire\Grids;

use App\Models\SalesDiscountRule;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Idea\Framework\Admin\Grids\Grid;
use Idea\Framework\Repository\Sales\SalesDiscountRuleRepository;


class SalesRulesGrid extends Grid
{

    public string $heading = 'Regras e Cupons de Desconto';
    public string $prefix = 'salesRulesGrid';
    public string $primaryKey = 'rule_id';
    public string $sortField = 'rule_id';
    public string $sortDirection = 'desc';


    public function table(Tables\Table $table): Tables\Table
    {

        return $table
            ->query(SalesDiscountRuleRepository::getData())
            ->heading($this->heading)
            ->columns([

                TextColumn::make('code')
                    ->label("Código/Cupom")
                    ->toggleable(false)
                    ->searchable(['code']),

                TextColumn::make('label')
                    ->label("Nome da Regra")
                    ->toggleable(false)
                    ->searchable(['label']),

                TextColumn::make('discount_value')
                    ->label("Valor do desconto em %")
                    ->toggleable(false)
                    ->searchable(['discount_value']),

                TextColumn::make('updated_at')
                    ->label("Atualizado em")
                    ->verticallyAlignCenter()
                    ->alignCenter()
                    ->wrap()
                    ->toggleable()
                    ->dateTime('d/m/Y H:i:s'),

            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('edit')
                        ->label('Editar')
                        ->icon('heroicon-o-pencil-square')
                        ->url(fn(SalesDiscountRule $record): string => route('wsdadm.sales-rules.edit', [
                            'id' => $record->rule_id
                        ])),

                    DeleteAction::make()
                        ->label('Excluir')
                        ->icon('heroicon-o-trash')
                        ->modalHeading("Exclusão da Regra")
                        ->modalDescription("Deseja Excluir essa Regra de Desconto?")
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Exclusão da Regra')
                                ->body('Regra Excluída com Sucesso')
                        )
                ]),
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

}
