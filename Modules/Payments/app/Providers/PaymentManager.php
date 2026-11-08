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
namespace Modules\Payments\Providers;

use Modules\Payments\Contracts\PaymentMethodInterface;

class PaymentManager
{

    protected array $methods = [];

    public function register(PaymentMethodInterface $method): void
    {
        $this->methods[$method->code()] = $method;
    }

    public function all(array $context = []): array
    {

        return array_filter(
            $this->methods,
            fn ($method) => $method->isAvailable($context)
        );
    }

    public function get(string $code): PaymentMethodInterface
    {
        if (!isset($this->methods[$code])) {
            throw new \InvalidArgumentException("Método de pagamento inválido");
        }

        return $this->methods[$code];
    }

}
