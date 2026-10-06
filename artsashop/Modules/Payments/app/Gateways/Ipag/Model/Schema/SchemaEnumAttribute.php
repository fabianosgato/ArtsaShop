<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * Não editar ou acrescentar à este arquivo se você quiser fazer o upgrade para versões
 * mais recentes no futuro.
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
class SchemaEnumAttribute extends SchemaAttribute
{
    protected array $values;

    public function __construct(Schema $schema, string $name)
    {
        parent::__construct($schema, $name);
        $this->values = [];
    }

    public static function from(Schema $schema, string $name): self
    {
        return parent::from($schema, $name);
    }

    public function values(array $values): self
    {
        $this->values = $values;
        return $this;
    }

    public function parseContextual($value)
    {
        $value = $this->matchesLoose($value);
        if (!is_null($value)) {
            return $value;
        }

        $many = $this->getValuesVerbose();
        throw new SchemaAttributeParseException($this, "Provided value is not one of {$many}");
    }

    private function matchesLoose($value)
    {
        return array_reduce($this->values, fn($x, $y) => $x ?? ($y == $value ? $y : null));
    }

    private function getValuesVerbose(): string
    {
        return implode(', ', $this->values);
    }
}
