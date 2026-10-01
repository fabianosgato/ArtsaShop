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

namespace Modules\System\Livewire\Form;

use App\Models\SysCarrier;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Idea\Framework\Repository\System\SysCarrierRepository;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Illuminate\Support\Facades\Session;


class SysCarrierForm extends FormComponent
{

    public ?array $data = [];

    protected function getModel(): string
    {
        return SysCarrier::class;
    }

    protected function getTitle(): string
    {
        return 'Transportadoras';
    }

    protected function getDescription(): string
    {
        if ($this->isEditing()) {
            return "Atualizar Transportadoras do sistema: {$this->data['carrier_name']}";
        }
        return 'Inserir uma nova Transportadora';
    }

    protected function getSuccessBody(): string
    {
        return 'O Status de produto foi inserido/atualizado com sucesso.';
    }

    protected function getRedirectUrl(): ?string
    {
        return route('wsdadm.carriers');
    }

    protected function saveData(array $data): SysCarrier
    {

        $sysCarrier = SysCarrierRepository::updateOrCreate(
            id: $data['carrier_id'],
            values: $data
        );

        if (!empty($data['carrier_id'])) {
            Session::flash('success', 'Transportadora atualizada com sucesso!');

        } else {
            Session::flash('success', 'Transportadora criada com sucesso!');
        }

        return $sysCarrier;

    }

    protected function getFormSchema(): array
    {
        return [
            Tabs::make('Tabs')->tabs([

                Tabs\Tab::make('Informações da Transportadora')->schema([

                    Hidden::make('carrier_id'),

                    TextInput::make('carrier_name')
                        ->label('Nome da Transportadora')
                        ->required(),

                    TextInput::make('multiplier')
                        ->label('Multiplicador da Transportadora')
                        ->numeric()
                        ->required(),

                    Select::make('pricing_type')
                        ->label('Tipo de Calculo')
                        ->helperText('Informe o tipo de calculo usado para o calculo dos preços: Peso Pesado OU Maior Peso (Peso Pesado OU Peso Cubado)')
                        ->options([
                            'WEIGHT' => 'Peso Pesado',
                            'GREATER_WEIGHT' => 'Maior peso',
                        ]),

                    Radio::make('status')
                        ->label('Transportadora Ativa?')
                        ->boolean()
                        ->required()

                ])

            ])

        ];
    }

}
