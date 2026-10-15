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
namespace Modules\Payments\Gateways\Ipag\Model\Schema\Exception;

use Throwable;

/**
 * @codeCoverageIgnore
 */
class MutatorAttributeException extends MutatorException
{
    public function __construct(string $attribute, ?string $message = null, ?Throwable $previous = null)
    {
        $attributeName = $attribute;
        $message ??= "Failed to validate/mutate attribute";
        parent::__construct("'{$attributeName}' {$message}");
    }
}
