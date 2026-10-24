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
namespace Modules\Payments\Gateways\Ipag\IO;

use Modules\Payments\Gateways\Ipag\Exception\ParseException;

class JsonSerializer implements SerializerInterface
{
    protected int $flags;
    protected int $depth;

    public function __construct(int $flags = 0, int $depth = 512)
    {
        $this->flags = $flags;
        $this->depth = $depth;
    }

    public function serialize(array $data): string
    {
        $data = json_encode($data, $this->flags, $this->depth);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new ParseException("Serialization data is not JSON parseable.");
        }

        return $data;
    }

    public function unserialize(string $data): array
    {
        $data = json_decode($data, true, $this->depth, $this->flags);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new ParseException("Received data is not JSON parseable: $data.");
        }

        return $data;
    }

    public function getContentType(): string
    {
        return 'application/json';
    }
}
