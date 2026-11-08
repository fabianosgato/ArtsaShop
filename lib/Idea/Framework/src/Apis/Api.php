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

namespace Idea\Framework\Apis;

class Api
{

    protected string $key;
    protected string $password;

    /**
     * Cria o array para o envio dos dados para os Headers das requisicoes.
     * @return string[]
     */
    public static function getHeaders(): array
    {
        return [
            "User-Agent: ArtsaShop Ecommerce",
            "Cache-Control: no-cache",
            'Content-Type: application/json',
            'Content-Type: multipart/form-data'
        ];
    }

}
