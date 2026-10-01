<?php

namespace Idea\Framework\Services\Payments\Ipag\Model\Schema;

use Idea\Framework\Services\Payments\Ipag\Model\Model;
use Idea\Framework\Services\Payments\Ipag\Model\Schema\Exception\MutatorAttributeException;

/**
 * @codeCoverageIgnore
 */
final class MutatorContext
{
    public Model $target;
    public string $attribute;
    public ?SchemaAttribute $attributeSchema;

    public function __construct(Model $target, string $attribute, ?SchemaAttribute $attributeSchema = null)
    {
        $this->target = $target;
        $this->attribute = $attribute;
        $this->attributeSchema = $attributeSchema;
    }

    public static function from(Model $target, string $attribute, ?SchemaAttribute $attributeSchema = null): self
    {
        return new self($target, $attribute, $attributeSchema);
    }

    public function assert($conditional, ?string $message = null): void
    {
        if (!$conditional) {
            $this->raise($message);
        }
    }

    public function raise(?string $message = null): void
    {
        $attributeAbsoluteName = $this->getAttributeAbsoluteName();
        throw new MutatorAttributeException($attributeAbsoluteName, $message);
    }

    public function getAttributeAbsoluteName(): string
    {
        return $this->attributeSchema ? $this->attributeSchema->getAbsoluteName() : $this->getAttributeRelativeName();
    }

    public function getAttributeRelativeName(): string
    {
        return implode('.', [$this->target->getName(), $this->attribute]);
    }
}
