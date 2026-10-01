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

use App\Models\CatalogProductStatus;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Idea\Framework\Repository\Catalog\CatalogProductStatusRepository;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Illuminate\Support\Facades\Session;

class CatalogProductStatusForm extends FormComponent
{

    public ?array $data = [];

    protected function getModel(): string
    {
        return CatalogProductStatus::class;
    }

    protected function getTitle(): string
    {
        return 'Status de produtos';
    }

    protected function getDescription(): string
    {
        if ($this->isEditing()) {
            return "Status de produtos: {$this->data['status']}";
        }
        return 'Inserir um Status de produto';
    }

    protected function getSuccessBody(): string
    {
        return 'O Status de produto foi inserido/atualizado com sucesso.';
    }

    protected function getRedirectUrl(): ?string
    {
        return route('wsdadm.product-status');
    }

    protected function getFormSchema(): array
    {
        return [
            Tabs::make('Tabs')->tabs([

                Tab::make('Informações do Status')->schema([

                    Hidden::make('status_id'),

                    TextInput::make('status')
                        ->label('Nome do Status')
                        ->helperText('Nome do status do produto')
                        ->required(),

                    TextInput::make('status_key')
                        ->label('KEY do Status')
                        ->helperText('Valor para identificar o status')
                        ->required(),


                ])
            ])
        ];
    }

    /**
     * @param array $data
     * @return \App\Models\CatalogProductStatus
     */
    protected function saveData(array $data): CatalogProductStatus
    {

        $catalogProductStatus = CatalogProductStatusRepository::updateOrCreate(
            id:$data['status_id'],
            values:$data
        );

        if (!empty($data['status_id'])) {
            Session::flash('success', 'Status atualizado com sucesso!');
        } else {
            Session::flash('success', 'Status inserido com sucesso!');
        }

        return $catalogProductStatus;

    }

}
