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

namespace Modules\SalesRules\Livewire\Form;

use App\Models\SalesDiscountRule;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Tabs;
use Filament\Support\RawJs;
use Idea\Framework\Repository\Sales\SalesDiscountRuleRepository;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class SalesRulesForm extends FormComponent
{

    public function mount(array $data = [], array $params = []): void
    {

        $this->data = $data;
        $this->params = $params;

        // Inicializa o form
        $this->initializeForm();

    }

    protected function getModel(): string
    {
        return SalesDiscountRule::class;
    }

    protected function getTitle(): string
    {
        return 'Regras de Desconto';
    }

    protected function getDescription(): string
    {
        if ($this->isEditing()) {
            return "Atualizar Regra de Desconto: {$this->data['label']} ({$this->data['code']})";
        }
        return 'Inserir nova Regra de Desconto';
    }

    protected function getSuccessBody(): string
    {
        return 'A Regra de Desconto foi inserida/atualizada com sucesso.';
    }

    protected function getRedirectUrl(): ?string
    {
        return route('wsdadm.sales-rules');
    }

    protected function getFormSchema(): array
    {

        return [
            Tabs::make('Tabs')->tabs([

                Tabs\Tab::make('Geral')->schema([

                    Hidden::make('rule_id'),

                    Fieldset::make('Informações Gerais da regra de Desconto/Cupom')
                        ->schema([

                            TextInput::make('label')
                                ->label('Nome da Regra')
                                ->helperText('Nome da regra para ser mostrada no site')
                                ->required(),

                            TextInput::make('code')
                                ->label('Código/Cupom')
                                ->helperText('Código da Regra ou Cupom de desconto que deve ser utilizado no site'),

                            Select::make('rule_type')
                                ->label('Tipo da Regra:')
                                ->options([
                                    'coupon' => 'Código de Cupom',
                                    'payment' => 'Usar em pagamentos'
                                ])
                                ->required()
                                ->searchable(false),

                            TextInput::make('discount_value')
                                ->label('Valor do desconto')
                                ->helperText('Valor do desconto a ser aplicado')
                                ->stripCharacters('')
                                ->mask(RawJs::make(<<<'JS'
                                    $money($input, ',', '.', 2)
                                JS))
                                ->formatStateUsing(fn ($state) => ! $state ? null : number_format($state, 2, ',', '.'))
                                ->dehydrateStateUsing(fn ($state) => (float) str_replace(['.', ','], ['', '.'], $state))
                                ->default(false),

                            Select::make('discount_type')
                                ->label('Tipo de desconto:')
                                ->options([
                                    'percent' => 'Porcentagem',
                                    'fixed' => 'Valor Fixo',
                                ])
                                ->required()
                                ->searchable(false),

                            Radio::make('is_active')
                                ->label('Regra ativa')
                                ->helperText('Quando Habilitado, pode ser usado no site')
                                ->boolean(),

                            TextInput::make('priority')
                                ->label('Prioridade:')
                                ->helperText('A prioridade define a ordenação quando a regra deve ser aplicada, se for zero (0) somente ela será aplicada')
                                ->required(false),

                        ])->columns(1),

                    Fieldset::make('Onde aplicar a Regra')
                        ->schema([

                            Select::make('apply_to')
                                ->label('Aplicar quando estiver no:')
                                ->options([
                                    'cart' => 'Carrinho de compras',
                                    'product' => 'Catálogo de Produtos',
                                ])
                                ->required()
                                ->searchable(false),

                            Select::make('payment_method')
                                ->label('Tipo pagamento:')
                                ->options([
                                    'pix' => 'Pix',
                                    'credit_card' => 'Cartão de Crédito',
                                    'boleto' => 'Boleto',
                                ])
                                ->required(false)
                                ->searchable(false),

                        ])->columns(1),

                    Fieldset::make('Configurações de valores')
                        ->schema([

                            TextInput::make('max_usage')
                                ->label('Valor máximo de usos')
                                ->helperText('Valor máximo de usos desse cupom para ele ficar desativado'),

                            TextInput::make('min_subtotal')
                                ->label('Valor minimo')
                                ->helperText('Valor minimo no carrinho para a regra ser aplicada'),

                            TextInput::make('max_subtotal')
                                ->label('Valor máximo')
                                ->helperText('Valor máximo no carrinho para a regra ser aplicada'),

                            DatePicker::make('starts_at')
                                ->label('Inicia em:')
                                ->helperText('Data de início da promoção/cupom'),

                            DatePicker::make('ends_at')
                                ->label('Finaliza em:')
                                ->helperText('Data de finalização da promoção/cupom')
                                ->filled(),

                        ])->columns(1),

                ])

            ])
        ];

    }

    protected function saveData(array $data): ?Model
    {

        $salesDiscountRule = SalesDiscountRuleRepository::updateOrCreate($data);

        if (!empty($data['rule_id'])) {
            Session::flash('success', 'Regra atualizada com sucesso!');

        } else {
            Session::flash('success', 'Regra criada com sucesso!');
        }

        return $salesDiscountRule;

    }

}
