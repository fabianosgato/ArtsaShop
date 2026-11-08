<?php

namespace Modules\Payments\Gateways\Ipag\Model\Schema\Exception;

use Modules\Payments\Gateways\Ipag\Model\Schema\SchemaAttribute;

/**
 * @codeCoverageIgnore
 */
class SchemaAttributeParseException extends SchemaException
{
    public function __construct(SchemaAttribute $attribute, ?string $message = null)
    {
        $attributeName = $attribute->getAbsoluteName();
        $message ??= "Failed to parse attribute {$attribute->getName()}";
        parent::__construct("'{$attributeName}' {$message}");
    }
}
