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

use DateTimeInterface;
use Modules\Payments\Gateways\Ipag\Model\Model;

/**
 * @codeCoverageIgnore
 */
final class Schema
{
    protected array $props;
    protected ?string $name;

    public function __construct(?string $name = null)
    {
        $this->props = [];
        $this->name = $name;
    }

    public function any(string $attribute): SchemaAttribute
    {
        return $this->set(SchemaAttribute::from($this, $attribute));
    }

    protected function set(SchemaAttribute $schemaAttribute): SchemaAttribute
    {
        $this->props[$schemaAttribute->getName()] = $schemaAttribute;
        return $schemaAttribute;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function int(string $attribute): SchemaAttribute
    {
        return $this->set(SchemaIntegerAttribute::from($this, $attribute));
    }

    public function string(string $attribute): SchemaAttribute
    {
        return $this->set(SchemaStringAttribute::from($this, $attribute));
    }

    public function date(string $attribute, string $format = DateTimeInterface::RFC3339): SchemaAttribute
    {
        return $this->set(SchemaDateAttribute::from($this, $attribute)->format($format));
    }

    public function bool(string $attribute): SchemaAttribute
    {
        return $this->set(SchemaBoolAttribute::from($this, $attribute));
    }

    public function enum(string $attribute, array $values): SchemaAttribute
    {
        return $this->set(SchemaEnumAttribute::from($this, $attribute)->values($values));
    }

    public function float(string $attribute): SchemaAttribute
    {
        return $this->set(SchemaFloatAttribute::from($this, $attribute));
    }

    public function has(string $attribute, string $class = Model::class): SchemaAttribute
    {
        return $this->set(SchemaRelationAttribute::from($this, $attribute, $class));
    }

    public function hasMany(string $attribute, string $class = Model::class): SchemaAttribute
    {
        return $this->set(SchemaRelationAttribute::from($this, $attribute, $class)->many());
    }

    public function array(string $attribute, ?SchemaAttribute $schema = null): SchemaAttribute
    {
        return $this->set(SchemaArrayAttribute::from($this, $attribute, $schema));
    }

    public function builder(): SchemaBuilder
    {
        if (!empty($this->props)) {
            $this->props = [];
        }

        return SchemaBuilder::from($this);
    }

    public function query(string $attribute): ?SchemaAttribute
    {
        return $this->props[$attribute] ?? null;
    }

    //

    public function getAttributes(): iterable
    {
        return $this->props;
    }

    protected function unset(SchemaAttribute $schemaAttribute): SchemaAttribute
    {
        unset($this->props[$schemaAttribute->getName()]);
        return $schemaAttribute;
    }
}
