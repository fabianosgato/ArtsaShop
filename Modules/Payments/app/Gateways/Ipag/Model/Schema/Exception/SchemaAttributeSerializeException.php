<?php

namespace Modules\Payments\Gateways\Ipag\Model\Schema\Exception;

use Modules\Payments\Gateways\Ipag\Model\Schema\SchemaAttribute;

/**
 * @codeCoverageIgnore
 */
class SchemaAttributeSerializeException extends SchemaException
{
    public function __construct(SchemaAttribute $attribute, ?string $message = null)
    {
        $attributeName = $attribute->getAbsoluteName();
        $message ??= "Failed to serialize attribute {$attribute->getName()}";
        parent::__construct("'{$attributeName}' {$message}");
    }
}
