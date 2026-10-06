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
final class SchemaBuilder
{
    protected Schema $target;

    public function __construct(Schema $target)
    {
        $this->target = $target;
    }

    public static function from(Schema $target): self
    {
        return new self($target);
    }

    public function any(string $attribute): SchemaAttribute
    {
        return $this->target->any($attribute);
    }

    public function int(string $attribute): SchemaAttribute
    {
        return $this->target->int($attribute);
    }

    public function string(string $attribute): SchemaAttribute
    {
        return $this->target->string($attribute);
    }

    public function date(string $attribute, string $format = DateTimeInterface::RFC3339): SchemaDateAttribute
    {
        return $this->target->date($attribute)->format($format);
    }

    public function bool(string $attribute): SchemaAttribute
    {
        return $this->target->bool($attribute);
    }

    public function enum(string $attribute, array $values): SchemaAttribute
    {
        return $this->target->enum($attribute, $values);
    }

    public function float(string $attribute): SchemaAttribute
    {
        return $this->target->float($attribute);
    }

    public function has(string $attribute, string $class = Model::class): SchemaAttribute
    {
        return $this->target->has($attribute, $class);
    }

    //

    public function hasMany(string $attribute, string $class = Model::class): SchemaRelationAttribute
    {
        return $this->target->hasMany($attribute, $class)->many();
    }

    public function build(): Schema
    {
        return $this->target;
    }
}
