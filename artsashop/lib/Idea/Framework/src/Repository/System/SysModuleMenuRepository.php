<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 *
 * É concedida permissão, gratuitamente, a qualquer pessoa que obtenha uma cópia
 * deste software e arquivos de documentação associados
 *
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */
namespace Idea\Framework\Repository\System;

use App\Models\SysModulesMenu;
use Idea\Framework\Repository\AbstractRepository;

class SysModuleMenuRepository extends AbstractRepository
{
    protected static $model = SysModulesMenu::class;

    /**
     * Insere/Atualiza um Menu de acesso ao Sistema
     * @param int|null $id
     * @param array $values
     * @return \App\Models\SysModulesMenu
     */
    public static function updateOrCreate(?int $id, array $values = []): SysModulesMenu
    {
        return self::getData()->updateOrCreate(
            attributes: [
                'module_menu_id' => $id
            ],
            values: $values
        );
    }

    public static function getMenusByModuleId(int $moduleId): ?\Illuminate\Database\Eloquent\Collection
    {

        $sysModuleMenu = self::loadModel()::query()
            ->where(
                column: 'module_id',
                operator: '=',
                value: $moduleId
            );

        if ($sysModuleMenu->exists())
            return $sysModuleMenu->get();

        return null;

    }

}
