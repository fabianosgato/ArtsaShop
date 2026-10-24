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
declare(strict_types=1);

namespace Idea\Framework\Repository\System;

use App\Models\SysModule;
use Idea\Framework\Repository\AbstractRepository;

class SysModuleRepository extends AbstractRepository
{

    protected static $model = SysModule::class;

    /**
     * Retorna os modulos ativos do sistema
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public static function getModules(): ?\Illuminate\Database\Eloquent\Collection
    {

        // Realiza a query para retornar os Modulos do sistema
        $modules = self::loadModel()::query()
            ->select([
                'module_id',
                'module_name',
                'module_order',
                'icon',
                'route_prefix',
                'status'
            ])
            ->where(
                column: 'status',
                operator: '=',
                value: true
            )
            ->orderBy('module_order');

        if ($modules->exists())
            return $modules->get();

        return null;

    }

    public static function getOptionsValues(): array
    {
        $options = [];

        $modules = self::getModules()->toArray();

        foreach ($modules as $module) {
            $options[$module['module_id']] = $module['module_name'];
        }

        return $options;

    }

}
