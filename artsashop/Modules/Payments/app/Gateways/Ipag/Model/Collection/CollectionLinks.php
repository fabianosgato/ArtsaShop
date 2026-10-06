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
 * CollectionLinks class
 *
 * @codeCoverageIgnore
 */
final class CollectionLinks extends Model
{
    protected function schema(SchemaBuilder $schema): Schema
    {
        $schema->string("first")->nullable();
        $schema->string("last")->nullable();
        $schema->string("prev")->nullable();
        $schema->string("next")->nullable();

        return $schema->build();
    }
}
