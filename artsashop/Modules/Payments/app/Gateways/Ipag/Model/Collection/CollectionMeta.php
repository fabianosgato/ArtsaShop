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
namespace Modules\Payments\Gateways\Ipag\Model\Collection;

use Modules\Payments\Gateways\Ipag\Model\Model;
use Modules\Payments\Gateways\Ipag\Model\Schema\Schema;
use Modules\Payments\Gateways\Ipag\Model\Schema\SchemaBuilder;

/**
 * CollectionMeta class
 *
 * @codeCoverageIgnore
 */
final class CollectionMeta extends Model
{
    protected function schema(SchemaBuilder $schema): Schema
    {
        $schema->int("current_page")->nullable();
        $schema->int("last_page")->nullable();
        $schema->int("from")->nullable();
        $schema->int("to")->nullable();
        $schema->int("per_page")->nullable();
        $schema->int("total")->nullable();

        return $schema->build();
    }
}
