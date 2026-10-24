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
 * O retorno usa o contrato Authenticatable do Laravel, em vez de App\Models\User.
 *
 * Assim, qualquer model de usuário compatível pode ser utilizado. A implementação concreta ficará responsável
 * por verificar as credenciais e rejeitar contas inativas.
 *
 * A emissão do token ficará atrás de outra abstração, para que TokenService também não precise
 * conhecer diretamente o Sanctum.
 *
 */
declare(strict_types=1);

namespace Idea\Framework\Contracts\Auth;

use Illuminate\Contracts\Auth\Authenticatable;

interface UserAuthenticatorInterface
{
    /**
     * Authenticate a user using the provided credentials.
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function authenticate(
        string $email,
        string $password
    ): Authenticatable;

}
