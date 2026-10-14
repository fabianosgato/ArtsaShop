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
namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiAuthLoginTest extends TestCase
{

    /**
     * Teste que identifica se o ususário criou corretamente o Token
     * @return void
     */
    public function test_user_can_login_and_receive_an_api_token(): void
    {
        // Arrange
        $email = 'api-login-test@example.com';
        $password = 'password123';

        $user = User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password),
            'status' => true,
        ]);

        // Act
        $response = $this->postJson('/api/auth/login', [
            'email' => $email,
            'password' => $password,
            'device_name' => 'web'
        ]);

        // Assert
        $response
            ->assertOk()
            ->assertJsonStructure([
                'token',
            ]);

        $this->assertDatabaseHas('sys_personal_access_tokens', [
            'tokenable_type' => User::class,
            'tokenable_id' => $user->getKey(),
        ]);

    }

    /**
     * Teste para identificar se o usuario está desativado
     * @return void
     */
    public function test_user_disable_can_login_and_receive_an_api_token(): void
    {
        // Arrange
        $email = 'api-login-test2@example.com';
        $password = 'password123';

        $user = User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password),
            'status' => false,
        ]);

        // Act
        $response = $this->postJson('/api/auth/login', [
            'email' => $email,
            'password' => $password,
            'device_name' => 'web'
        ]);

        // Assert
        $response->assertUnauthorized();

    }

    /**
     * Teste para identificar se o usuario errou a senha
     * @return void
     */
    public function test_user_invalid_password(): void
    {

        // Arrange
        $email = 'api-login-test4@example.com';
        $password = 'password123';

        User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password),
            'status' => true,
        ]);

        // Act
        $response = $this->postJson('/api/auth/login', [
            'email' => $email,
            'password' => 'password1234',
            'device_name' => 'web'
        ]);

        // Assert
        $response->assertUnauthorized();

    }

    /**
     * Teste de usuario inexistente no sistema
     * @return void
     */
    public function test_user_doesnt_exists(): void
    {
        // Arrange
        $email = 'api-login-546654@example.com';
        $password = '545654654';

        // Act
        $response = $this->postJson('/api/auth/login', [
            'email' => $email,
            'password' => $password,
            'device_name' => 'web'
        ]);

        // Assert
        $response->assertUnauthorized();

    }



}
