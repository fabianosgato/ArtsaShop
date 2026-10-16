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
namespace Tests\Feature\Idea\Admin;

use App\Models\User;
use Idea\Framework\Admin\Permissions;
use Idea\Framework\Repository\System\SysUserRepository;
use Idea\Framework\Services\Auth\UserAuthenticator;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PermissionsTest extends TestCase
{

    public function test_getUserData(): void
    {

        // Arrange: cria um usuário real no banco de testes.
        $user = User::factory()->create([
            'name' => 'Usuário de Teste',
            'status' => true,
            'password' => Hash::make('mlr1234seew'),
        ]);

        // Act: utiliza o provider real configurado no Laravel.
        $authenticator = new UserAuthenticator();

        $authenticatedUser = $authenticator->authenticate(
            $user->email,
            'mlr1234seew'
        );

        $this->actingAs($authenticatedUser);

        // Retorna os dados do usuário
        $userData = app(Permissions::class)->getUserData();

        // Assert: verifica se a autenticação retornou o usuário correto.
        $this->assertInstanceOf(User::class, $authenticatedUser);

        // Assert: verifica se o usuario criado é o mesmo do usuário vindo de permissions
        $this->assertSame(
            $user->user_id,
            $userData['user_id']
        );

    }

    public function test_checkPermissions(): void
    {

        // Arrange: Busca um usuário do banco de dados
        $user = SysUserRepository::find(1);

        $this->actingAs($user);

        // Act: Retorna uma permissao do usuário
        $permissionIsAvaliable = app(Permissions::class)->checkPermissions(
            moduleMenuId: 1,
            action:'view'
        );

        $this->assertIsBool(true, $permissionIsAvaliable);

    }

    public function test_not_checkPermissions(): void
    {

        // Arrange: Busca um usuário do perfil sem permissão
        $user = SysUserRepository::find(36);
        $this->actingAs($user);

        // Act: Retorna uma permissao do usuário
        $permissionIsAvaliable = app(Permissions::class)->checkPermissions(
            moduleMenuId: 1, // Modulo de Grupos em Configuração
            action:'view'
        );

        // Asert
        $this->assertIsBool(true, $permissionIsAvaliable);

    }

}
