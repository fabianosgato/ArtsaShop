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
declare(strict_types=1);

namespace Idea\Framework\Repository\System;

use App\Models\SysModule;
use Idea\Framework\Repository\AbstractRepository;

class SysModuleRepository extends AbstractRepository
{

    protected static $model = SysModule::class;

    /**
     * Retorna os modulos do sistema
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public static function getModules(): ?\Illuminate\Database\Eloquent\Collection
    {

        // Realiza a query para retornar os Modulos do sistema
        $modules = self::loadModel()::query()->select([
            'module_id',
            'module_name'
        ]);

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

    /**
     * Atualiza os dados do módulo
     * @param int|null $id
     * @param array $values
     * @return SysModule
     */
    public static function updateOrCreate(?int $id, array $values = []): SysModule
    {

        return self::getData()->updateOrCreate(
            attributes: [
                'module_id' => $id
            ],
            values: $values
        );

    }


}
