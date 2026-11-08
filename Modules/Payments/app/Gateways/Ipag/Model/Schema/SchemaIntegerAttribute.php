<?php

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
