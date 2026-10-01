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

use App\Models\SysGroup;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Idea\Framework\Admin\Components\Forms\PermissionMatrix;
use Idea\Framework\Repository\System\SysGroupProfileRepository;
use Idea\Framework\Repository\System\SysGroupRepository;
use Idea\Framework\Repository\System\SysModuleMenuRepository;
use Idea\Framework\View\Wsdadm\Components\FormComponent;
use Illuminate\Support\Facades\Session;

class SysGroupForm extends FormComponent
{

    public ?array $data = [];
    public array $permissions = [];

    protected function getModel(): string
    {
        return SysGroup::class;
    }

    protected function getTitle(): string
    {
        return 'Grupo de usuários do sistema';
    }

    protected function getDescription(): string
    {
        if ($this->isEditing()) {
            return "Atualizar Grupo {$this->data['group_name']}";
        }
        return 'Inserir um novo Grupo de Usuários';
    }

    protected function getSuccessBody(): string
    {
        return 'O Grupo foi inserido/atualizado com sucesso.';
    }

    protected function getRedirectUrl(): ?string
    {
        return route('wsdadm.sysgroups');
    }

    public function formPermissions(int $groupId): array
    {
        return [
            PermissionMatrix::make('sys_group_permissions')
                ->label('Permissoes do Grupo')
                ->group($groupId)
        ];
    }

    protected function getFormSchema(): array
    {

        return [

            Tabs::make('Tabs')
                ->tabs([
                    Tab::make('Informações do Grupo')
                        ->schema([
                            Hidden::make('group_id'),
                            TextInput::make('group_name')
                                ->required(),
                            Radio::make('status')
                                ->options([
                                    true => 'Habilitado',
                                    false => 'Desabilitado',
                                ]),
                        ]),

                    Tab::make('Permissões do Grupo')
                        ->schema(
                            $this->formPermissions(
                                $this->data['group_id'] ?? 0
                            )
                        ),

                ]),
        ];
    }

    /**
     * Salva os registros na base
     * @param array $data
     * @return SysGroup
     */
    protected function saveData(array $data): SysGroup
    {

        // Insere/Atualiza os dados do Grupo de Usuários
        $sysGroup = SysGroupRepository::getData()->updateOrCreate(
            attributes: [
                'group_id' => $data['group_id'] ?? null
            ],
            values: [
                'group_name' => $data['group_name'],
                'status' => $data['status'] ?? 0
            ]
        );

        if ($sysGroup) {

            if (isset($data['sys_group_permissions'])) {

                foreach ($data['sys_group_permissions'] as $menuId => $sysGroupPermission) {

                    $sysModuleMenus = SysModuleMenuRepository::getData()->where(
                        column: 'module_menu_id',
                        operator: '=',
                        value: $menuId
                    );

                    if ($sysModuleMenus->exists()) {

                        // Insere/Atualiza as permissões do grupo de usuario
                        SysGroupProfileRepository::getData()->updateOrCreate(
                            attributes: [
                                'group_id' => $sysGroup->group_id,
                                'module_menu_id' => $sysModuleMenus->first()->module_menu_id
                            ],
                            values: [
                                'view' => $sysGroupPermission['view'] ?? false,
                                'info' => $sysGroupPermission['info'] ?? false,
                                'altr' => $sysGroupPermission['altr'] ?? false,
                                'excl' => $sysGroupPermission['excl'] ?? false,
                            ]
                        );

                    }

                }

            }

        }

        if ($data['group_id']) {
            Session::flash('success', 'Grupo de usuário atualizado com sucesso!');
        } else {
            Session::flash('success', 'Grupo de usuário inserido com sucesso!');
        }

        return $sysGroup;

    }

}
