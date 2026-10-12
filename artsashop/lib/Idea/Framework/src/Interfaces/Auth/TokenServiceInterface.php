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
declare(strict_types=1);

namespace Idea\Framework\Interfaces\Auth;

use Idea\Framework\Interfaces\ServiceInterface;

interface TokenServiceInterface extends ServiceInterface
{
    /**
     * Authenticate the user and issue an access token.
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function issueToken(
        string $email,
        string $password,
        string $deviceName
    ): string;

}

