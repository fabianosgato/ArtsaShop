<?php
/**
 * Lef Tecnologia
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

namespace Idea\Framework\Repository\Logs;

use App\Models\SysLog;
use Idea\Framework\Repository\AbstractRepository;

class SysLogsRepository extends AbstractRepository
{

    protected static $model = SysLog::class;

    public static function getData()
    {
        return self::loadModel()::query();
    }

}
