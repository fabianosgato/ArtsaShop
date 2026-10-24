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

/**
 * @codeCoverageIgnore
 */
class SchemaFloatAttribute extends SchemaAttribute
{
    protected ?float $min = null;
    protected ?float $max = null;

    public function min(?float $min): self
    {
        $this->min = $min;
        return $this;
    }

    public function max(?float $max): self
    {
        $this->max = $max;
        return $this;
    }

    public function parseContextual($value)
    {
        if (is_int($value)) {
            $value = (float)$value;
        }

        if (!is_null($this->min) && $value < $this->min) {
            throw new SchemaAttributeParseException($this, "Provided value '{$value}' is less than the minimum value of {$this->min}");
        }

        if (!is_null($this->max) && $value > $this->max) {
            throw new SchemaAttributeParseException($this, "Provided value '{$value}' is greater than the maximum value of {$this->max}");
        }

        if (is_float($value)) {
            return $value;
        }

        throw new SchemaAttributeParseException($this, "Provided value '$value' is not a floating-point number");
    }
}
