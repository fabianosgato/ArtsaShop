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
namespace Idea\Framework\Concerns;

trait ResultApiResponse
{

    public function response($request = null): array
    {

        return [
            'request_info' => [
                'success' => true
            ],
            'request_parameters' => [],
            'request_metadata' => [
                'created_at' => date('Y-m-d H:i:s'),
                'processed_at' => date('Y-m-d H:i:s'),
            ],
            'data' => $request
        ];

    }

    public function error(string $message): array
    {
        return [
            'request_info' => [
                'success' => false
            ],
            'request_parameters' => [],
            'request_metadata' => [
                'created_at' => date('Y-m-d H:i:s'),
                'processed_at' => date('Y-m-d H:i:s'),
            ],
            'message' => $message
        ];
    }

}
