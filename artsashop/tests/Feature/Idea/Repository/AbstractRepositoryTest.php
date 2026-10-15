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
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class AbstractRepositoryTest extends TestCase
{

    public function testUpdate()
    {

    }

    public function testGetData()
    {

    }

    public function testDelete()
    {

    }

    public function testAll()
    {

    }

    public function testCreate()
    {

        $repository = new class extends AbstractRepository {
            protected static $model = User::class;
        };

        $user = $repository::create([
            ''
        ]);

        $this->assertInstanceOf(User::class, $user);

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

    public function testSearchRecordNonexistent()
    {

        $repository = new class extends AbstractRepository {
            protected static $model = User::class;
        };

        $user = $repository::find(2);

        $this->assertNull($user);

    }

}
