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

namespace Feature\Idea\Repository;

use App\Models\User;
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class AbstractRepositoryTest extends TestCase
{

    private string $testEmail = "create@example.com";

    public function testCreate()
    {

        $repository = new class extends AbstractRepository {
            protected static $model = User::class;
        };

        $model = $repository::create(
            attributes: [
                'email' => $this->testEmail,
                'email_verified_at' => null,
            ],
            values: [
                'name' => 'Usuário Teste',
                'group_id' => 1,
                'password' => bcrypt('password'),
                'remember_token' => '',
                'status' => true,
            ]
        );

        $this->assertInstanceOf(User::class, $model);

        $this->assertDatabaseHas('sys_users', [
            'email' => $this->testEmail,
            'name' => 'Usuário Teste',
        ]);

    }

    public function testCreateExistingRecord()
    {

        $repository = new class extends AbstractRepository {
            protected static $model = User::class;
        };

        $user = User::query()->where(
            column: 'email',
            operator: '=',
            value:$this->testEmail
        )->first();

        $model = $repository::create(
            [
                'email' => $this->testEmail,
            ],
            [
                'name' => 'Outro Nome',
                'status' => true,
            ]
        );

        $this->assertNotNull($user);
        $this->assertSame($user->getKey(), $model->getKey());

        $this->assertDatabaseCount(
            'sys_users',
            User::query()->count()
        );

    }

    public function testUpdate(): void
    {
        $repository = new class extends AbstractRepository {
            protected static $model = User::class;
        };

        $user = User::query()->where(
            column: 'email',
            operator: '=',
            value:$this->testEmail
        )->first();

        $newName = 'Nome atualizado pelo teste';

        $update = $repository::update(
            $user->getKey(),
            [
                'name' => $newName,
            ]
        );

        $this->assertIsInt($update);

        $this->assertEquals(1, $update);

        $this->assertDatabaseHas('sys_users', [
            'user_id' => $user->getKey(),
            'name' => $newName,
        ]);

    }

    public function testGetData()
    {
        $repository = new class extends AbstractRepository {
            protected static $model = User::class;
        };

        $builder = $repository::getData();

        $this->assertInstanceOf(
            Builder::class,
            $builder
        );

    }

    public function testDelete(): void
    {
        $repository = new class extends AbstractRepository {
            protected static $model = User::class;
        };

        $user = User::query()->where(
            column: 'email',
            operator: '=',
            value:$this->testEmail
        )->first();

        $delete = $repository::delete($user->getKey());

        $this->assertIsInt($delete);

        $this->assertEquals(1, $delete);

        $this->assertModelMissing($user);

    }

    public function testAll(): void
    {
        $repository = new class extends AbstractRepository {
            protected static $model = User::class;
        };

        $models = $repository::all();

        $this->assertInstanceOf(
            Collection::class,
            $models
        );

        $this->assertCount(
            User::query()->count(),
            $models
        );

        $this->assertEquals(
            User::query()->pluck('user_id')->sort()->values()->all(),
            $models->pluck('user_id')->sort()->values()->all()
        );

    }

    public function testLoadModel()
    {

        $repository = new class extends AbstractRepository {
            protected static $model = User::class;
        };

        $model = $repository::loadModel();

        $this->assertInstanceOf(User::class, $model);
        $this->assertInstanceOf(Model::class, $model);

    }

    public function testFind()
    {

        $repository = new class extends AbstractRepository {
            protected static $model = User::class;
        };

        $model = $repository::find(1);

        $this->assertInstanceOf(User::class, $model);

    }

    public function testFindRecordNonexistent()
    {

        $repository = new class extends AbstractRepository {
            protected static $model = User::class;
        };

        $user = $repository::find(2);

        $this->assertNull($user);

    }

}
