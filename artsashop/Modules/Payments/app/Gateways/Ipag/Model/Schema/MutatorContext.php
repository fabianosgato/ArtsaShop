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

use Modules\Payments\Gateways\Ipag\Model\Model;
use Modules\Payments\Gateways\Ipag\Model\Schema\Exception\MutatorAttributeException;

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

    /**
     * @throws \Modules\Payments\Gateways\Ipag\Model\Schema\Exception\MutatorAttributeException
     */
    public function assert($conditional, ?string $message = null): void
    {
        if (!$conditional) {
            $this->raise($message);
        }
    }

    /**
     * @throws \Modules\Payments\Gateways\Ipag\Model\Schema\Exception\MutatorAttributeException
     */
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
