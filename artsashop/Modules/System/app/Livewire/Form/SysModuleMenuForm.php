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
use App\Models\SysModulesMenu;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Idea\Framework\Repository\System\SysModuleMenuRepository;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Illuminate\Support\Facades\Session;


class SysModuleMenuForm extends FormComponent
{

    public ?array $data = [];
    public int $moduleId;

    protected function getModel(): string
    {
        return SysModulesMenu::class;
    }

    protected function getTitle(): string
    {
        return "Acessos do sistema";
    }

    protected function getDescription(): string
    {
        if ($this->isEditing()) {
            return "Atualizar acesso do sistema: {$this->data['menu_name']}";
        }
        return 'Inserir uma novo acesso ao sistema';
    }

    protected function getSuccessBody(): string
    {
        return 'O acesso do sistema foi inserido/atualizado com sucesso.';
    }

    protected function getRedirectUrl(): ?string
    {
        return route('wsdadm.sysmenu', [
            'moduleId' => $this->params['moduleId']
        ]);
    }

    protected function getFormSchema(): array
    {

        return [

            Tabs::make('Tabs')->tabs([

                Tab::make('Informações do Acesso')->schema([

                    Hidden::make('module_menu_id'),

                    Select::make('module_id')
                        ->label('Módulo')
                        ->options(SysModule::all()->pluck('module_name', 'module_id'))
                        ->searchable(),

                    TextInput::make('menu_name')
                        ->label('Nome do Menu'),

                    TextInput::make('access_type')
                        ->label('Tipo de Acesso'),

                    TextInput::make('menu_link')
                        ->label('Link de Acesso'),

                    TextInput::make('menu_order')
                        ->label('Ordenação'),

                    Radio::make('is_visible')
                        ->label('Visivel no menu lateral')
                        ->boolean(
                            'Habilitado',
                            'Desabilitado'
                        ),

                    Radio::make('status')
                        ->boolean()
                        ->boolean(
                            'Habilitado',
                            'Desabilitado'
                        ),
                ])

            ])
        ];
    }

    protected function saveData(array $data): SysModulesMenu
    {

        $sysModuleMenu = SysModuleMenuRepository::updateOrCreate(
            id:$data['module_menu_id'] ?? null,
            values: $data
        );

        if (!empty($data['module_menu_id'])) {
            Session::flash('success', 'Acesso do sistema atualizado com sucesso!');

        } else {
            Session::flash('success', 'Acesso do sistema criado com sucesso!');
        }

        return $sysModuleMenu;

    }


}
