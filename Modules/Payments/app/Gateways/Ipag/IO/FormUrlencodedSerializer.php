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

class FormUrlencodedSerializer implements SerializerInterface
{
    public function __construct()
    {
    }

    public function serialize(array $data): string
    {
        $output = '';

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $key = $key . '[]';

                foreach ($value as $v) {
                    $output .= $key . '=' . urlencode($v) . '&';
                }
            } else {
                $output .= $key . '=' . urlencode($value) . '&';
            }
        }

        return rtrim($output, '&');
    }

    public function unserialize(string $data): array
    {
        $pieces = explode('&', $data);
        $output = [];

        foreach ($pieces as $piece) {
            [$key, $value] = explode('=', $piece);
            $output[$key] = urldecode($value);
        }

        return $output;
    }

    public function getContentType(): string
    {
        return 'application/x-www-form-urlencoded';
    }
}
