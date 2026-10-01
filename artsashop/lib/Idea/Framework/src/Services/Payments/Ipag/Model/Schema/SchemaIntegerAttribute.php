<?php

namespace Idea\Framework\Services\Payments\Ipag\Model\Schema;

use Idea\Framework\Services\Payments\Ipag\Model\Schema\Exception\SchemaAttributeParseException;

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
