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
class SchemaBoolAttribute extends SchemaAttribute
{
    protected array $positiveMatches;
    protected array $negativeMatches;

    public function __construct(Schema $schema, string $name)
    {
        parent::__construct($schema, $name);
        $this->positiveMatches = [];
        $this->negativeMatches = [];
    }

    public function positives(array $matches): self
    {
        $this->positiveMatches = $matches;
        return $this;
    }

    public function negatives(array $matches): self
    {
        $this->negativeMatches = $matches;
        return $this;
    }

    public function parseContextual($value)
    {
        if (is_integer($value)) {
            return boolval($value);
        }

        if (is_bool($value)) {
            return $value;
        }

        if ($this->isNegativeMatch($value)) {
            return false;
        }

        if ($this->isPositiveMatch($value)) {
            return true;
        }

        throw new SchemaAttributeParseException($this, "Provided value '$value' is not a boolean");
    }

    protected function isNegativeMatch($value): bool
    {
        return array_reduce($this->negativeMatches, fn($carry, $current) => $carry || $current == $value ? true : false, false);
    }

    protected function isPositiveMatch($value): bool
    {
        return array_reduce($this->positiveMatches, fn($carry, $current) => $carry || $current == $value ? true : false, false);
    }
}
