<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 *
 * É concedida permissão, gratuitamente, a qualquer pessoa que obtenha uma cópia
 * deste software e arquivos de documentação associados
 *
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */
namespace Modules\Payments\Gateways\Ipag\Model\Schema;

use DateTimeInterface;
use Modules\Payments\Gateways\Ipag\Model\Schema\Exception\SchemaAttributeParseException;
use Modules\Payments\Gateways\Ipag\Util\DateUtil;

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

    public static function from(Schema $schema, string $name): SchemaAttribute
    {
        return parent::from($schema, $name);
    }

    /**
     * @throws \Modules\Payments\Gateways\Ipag\Model\Schema\Exception\SchemaAttributeParseException
     */
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

    public function serialize($value)
    {
        if (is_null($value)) {
            return null;
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
