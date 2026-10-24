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

use Modules\Payments\Gateways\Ipag\Model\Schema\Exception\SchemaAttributeParseException;
use Modules\Payments\Gateways\Ipag\Model\Schema\Exception\SchemaAttributeSerializeException;

/**
 * @codeCoverageIgnore
 */
class SchemaArrayAttribute extends SchemaAttribute
{
    protected SchemaAttribute $childrenSchema;

    public function __construct(Schema $schema, string $name, ?SchemaAttribute $childrenSchema = null)
    {
        parent::__construct($schema, $name);
        $this->childrenSchema = $childrenSchema;
    }

    public static function from(Schema $schema, string $name, ?SchemaAttribute $childrenSchema = null): self
    {
        return new self($schema, $name, $childrenSchema);
    }

    public function parseContextual($value)
    {
        if (is_iterable($value)) {
            if (!is_array($value)) {
                $value = iterator_to_array($value);
            }
        }

        if (is_array($value)) {
            return array_map(fn($v) => $this->childrenSchema->parse($v), $value);
        }

        $arrayDefinition = $this->getArrayDefinitionString();
        throw new SchemaAttributeParseException($this, "Provided value is not a valid {$arrayDefinition}");
    }

    //

    private function getArrayDefinitionString(): string
    {
        $childrenType = $this->getGenericDefinitionString();
        return "array<{$childrenType}>";
    }

    private function getGenericDefinitionString(): string
    {
        return $this->childrenSchema ? $this->childrenSchema->getType() : '*';
    }

    //

    public function serialize($value)
    {
        if (is_null($value)) {
            return null;
        }

        if (is_iterable($value)) {
            if (!is_array($value)) {
                $value = iterator_to_array($value);
            }

            return array_map(
                fn($serializable) => $this->childrenSchema ? $this->childrenSchema->serialize($serializable) : $serializable,
                $value
            );
        }

        throw new SchemaAttributeSerializeException($this, "Provided value is not a valid array to be serialized");
    }
}
