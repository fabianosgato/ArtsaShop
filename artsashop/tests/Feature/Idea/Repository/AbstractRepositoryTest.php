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
namespace Feature\Idea\Repository;

use App\Models\User;
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class AbstractRepositoryTest extends TestCase
{

    public function test_load_model_returns_configured_model_instance(): void
    {

        $repository = new class extends AbstractRepository {
            protected static $model = User::class;
        };

        $model = $repository::loadModel();

        $this->assertInstanceOf(User::class, $model);
        $this->assertInstanceOf(Model::class, $model);

    }



}
