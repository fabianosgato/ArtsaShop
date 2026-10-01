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

use App\Models\SysGroup;
use App\Models\User;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Idea\Framework\Repository\System\SysUserRepository;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SysUserForm extends FormComponent
{

    public ?array $data = [];

    protected function getModel(): string
    {
        return User::class;
    }

    protected function getTitle(): string
    {
        return 'Usuários do Sistema';
    }

    protected function getDescription(): string
    {
        if ($this->isEditing()) {
            return "Atualizar Usuário: {$this->data['name']}";
        }
        return 'Inserir um novo Usuário';
    }

    protected function getSuccessBody(): string
    {
        return 'O Usuário foi inserido/atualizado com sucesso.';
    }

    protected function getRedirectUrl(): ?string
    {
        return route('wsdadm.sysusers');
    }

    protected function getFormSchema(): array
    {
        return [

            Tabs::make('Tabs')->tabs([

                Tabs\Tab::make('Informações do Usuário')->schema([

                    Hidden::make('user_id'),
                    TextInput::make('name')
                        ->label('Nome do Usuário')
                        ->required(),

                    Select::make('group_id')
                        ->label('Grupo de Acesso')
                        ->options(SysGroup::all()->pluck('group_name', 'group_id'))
                        ->required()
                        ->searchable(),

                    TextInput::make('email')
                        ->required()
                        ->label('E-mail'),

                    TextInput::make('password')
                        ->type('password')
                        ->label('Senha')
                        ->required(fn(string $context): bool => $context === 'create'),

                    Radio::make('status')
                        ->options([
                            true => 'Habilitado',
                            false => 'Desabilitado'
                        ])

                ])

            ])
        ];
    }


    protected function saveData(array $data): User
    {

        if ($data['password'] == '') {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        if (!empty($data['user_id'])) {
            // Atualiza os dados do usuario
            $model = SysUserRepository::getData()->updateOrCreate(
                attributes: [
                    'user_id' => $data['user_id']
                ],
                values:$data
            );

            Session::flash('success', 'Usuario atualizado com sucesso!');

        } else {
            $model = SysUserRepository::getData()->firstOrCreate(
                attributes: [
                    'user_id' => $data['user_id'] ?? null
                ],
                values:$data
            );

            Session::flash('success', 'Usuario criado com sucesso!');
        }

        return $model;

    }

}
