<?php

namespace Idea\Framework\Services\Payments\Ipag\Model\Schema\Exception;

use Idea\Framework\Services\Payments\Ipag\Model\Schema\SchemaAttribute;

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
