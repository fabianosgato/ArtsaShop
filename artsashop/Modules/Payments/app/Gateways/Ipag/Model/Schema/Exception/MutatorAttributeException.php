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
