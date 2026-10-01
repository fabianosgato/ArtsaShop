<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */

namespace Modules\System\Livewire\Form;

use App\Models\SysModule;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Idea\Framework\Repository\System\SysModuleRepository;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Illuminate\Support\Facades\Session;

class SysModuleForm extends FormComponent
{

    public ?array $data = [];

    protected function getModel(): string
    {
        return SysModule::class;
    }

    protected function getTitle(): string
    {
        return 'Módulos do sistema';
    }

    protected function getDescription(): string
    {
        if ($this->isEditing()) {
            return "Atualizar Módulo {$this->data['module_name']}";
        }
        return 'Inserir um novo módulo do sistema';
    }

    protected function getSuccessBody(): string
    {
        return 'O Módulo foi inserido/atualizado com sucesso.';
    }

    protected function getRedirectUrl(): ?string
    {
        return route('wsdadm.sysmodules');
    }

    protected function getFormSchema(): array
    {

        return [
            Tabs::make('Tabs')->tabs([

                Tab::make('Informações do Módulo')->schema([

                    Hidden::make('module_id'),

                    TextInput::make('module_name')
                        ->label('Nome do Módulo')
                        ->required(),

                    TextInput::make('module_order')
                        ->label('Ordenação'),

                    TextInput::make('icon')
                        ->label('Icone Font Awesome'),

                    TextInput::make('route_prefix')
                        ->label('Prefixo da Rota'),

                    Radio::make('status')
                        ->options([
                            true => 'Habilitado',
                            false => 'Desabilitado'
                        ])
                ]),

            ]),

        ];
    }

    protected function saveData(array $data): SysModule
    {

        // Insere/Atualiza o Módulo do sistema
        $sysModule = SysModuleRepository::updateOrCreate(
            id: $data['module_id'] ?? 0,
            values: $data
        );

        if (!empty($data['module_id'])) {
            Session::flash('success', 'Módulo atualizado com sucesso!');

        } else {
            Session::flash('success', 'Módulo criado com sucesso!');

        }

        return $sysModule;

    }

}
