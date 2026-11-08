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
