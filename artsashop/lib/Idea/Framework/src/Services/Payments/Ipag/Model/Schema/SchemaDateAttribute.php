<?php

namespace Idea\Framework\Services\Payments\Ipag\Model\Schema;

use DateTimeInterface;
use Idea\Framework\Services\Payments\Ipag\Model\Schema\Exception\SchemaAttributeParseException;
use Idea\Framework\Services\Payments\Ipag\Util\DateUtil;

/**
 * @codeCoverageIgnore
 */
class SchemaDateAttribute extends SchemaAttribute
{
    protected string $format;

    public function __construct(Schema $schema, string $name, string $format = DateTimeInterface::RFC3339)
    {
        parent::__construct($schema, $name);
        $this->format = $format;
    }

    //

    public static function from(Schema $schema, string $name): self
    {
        return parent::from($schema, $name);
    }

    public function parseContextual($value)
    {
        if (is_string($value) && $this->format) {
            $value = DateUtil::tryParseDate($value, $this->format);
        }

        if (!$value instanceof DateTimeInterface) {
            throw new SchemaAttributeParseException($this, "Provided value is not a valid date");
        }

        return $value;
    }

    //

    public function serialize($value)
    {
        if (is_null($value)) {
            return $value;
        }

        if ($this->getFormat()) {
            return $value->format($this->getFormat());
        }

        return $value;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function format(string $format): self
    {
        $this->format = $format;
        return $this;
    }
}
