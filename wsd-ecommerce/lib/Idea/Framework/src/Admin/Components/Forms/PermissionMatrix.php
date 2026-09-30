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

namespace Idea\Framework\Admin\Components\Forms;

use Filament\Forms\Components\Field;
use Idea\Framework\Repository\System\SysGroupProfileRepository;
use Idea\Framework\Repository\System\SysModuleMenuRepository;
use Idea\Framework\Repository\System\SysModuleRepository;

class PermissionMatrix extends Field
{

    protected string $view = 'idea-components::wsdadmin.forms.permission-matrix';

    public ?int $groupId = null;

    protected function setUp(): void
    {

        parent::setUp();

        $this->default([]);

        $this->afterStateHydrated(

            function ($component, $state) {
                if ($this->groupId) {
                    $component->state(
                        SysGroupProfileRepository::getPermissionsByGroup(
                            $this->groupId
                        )
                    );
                }

            }

        );

    }

    public function getActions(): array
    {

      return [
          'view' => 'Visualizar',
          'info' => 'Informações',
          'altr' => 'Alterar',
          'excl' => 'Ecluir',
      ];

    }
    public function group(?int $id): static
    {
        $this->groupId = $id;
        return $this;
    }

    public function getPermissions()
    {

        $formData = [];

        // Retorna os modulos do sistema
        $sysModules = SysModuleRepository::getModules();

        foreach ($sysModules as $index => $sysModule) {

            $formData[$index] = [
                'module' => $sysModule->module_name
            ];

            $sysModuleMenus = SysModuleMenuRepository::getMenusByModuleId($sysModule->module_id);

            if ($sysModuleMenus) {

                foreach ($sysModuleMenus as $sysModuleMenu) {

                    $formData[$index]['permissions'][$sysModuleMenu->menu_link] = [
                        'id' => $sysModuleMenu->module_menu_id,
                        'title' => $sysModuleMenu->menu_name
                    ];

                    foreach ($this->getActions() as $ind => $action) {

                        // Retorna se a permissão está vinculada
                        $sysGroupProfile = SysGroupProfileRepository::getPermission(
                            $this->groupId,
                            $sysModuleMenu->module_menu_id,
                            $ind
                        );

                        $formData[$index]['permissions'][$sysModuleMenu->menu_link]['actions'][] = [
                            'label' => $action,
                            'action' => $ind,
                            'input_name' => "{$sysModuleMenu->menu_link}.{$ind}",
                            'checked' => $sysGroupProfile
                        ];

                    }

                }

            }

        }

        return $formData;

    }

}
