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
namespace Modules\Payments\Gateways\Ipag\Model\Schema;

use Modules\Payments\Gateways\Ipag\Model\Schema\Exception\SchemaAttributeParseException;

/**
 * @codeCoverageIgnore
 */
class SchemaIntegerAttribute extends SchemaAttribute
{
    public function parseContextual($value)
    {
        if (is_integer($value)) {
            return $value;
        }

        throw new SchemaAttributeParseException($this, "Provided value '$value' is not an integer");
    }
}
