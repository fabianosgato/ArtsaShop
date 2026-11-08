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

use Closure;

/**
 * @codeCoverageIgnore
 */
final class Mutator
{
    public ?Closure $getter;
    public ?Closure $setter;

    public function __construct(?Closure $getter = null, ?Closure $setter = null)
    {
        $this->getter = $getter;
        $this->setter = $setter;
    }
}
