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

namespace Feature\Idea\Services;

use Idea\Framework\Services\ServiceCache;
use Tests\TestCase;

class ServiceCacheTest extends TestCase
{

    public function testExpireInIntVal(): void
    {

        // Arrange: Instancia a classe de Cache
        $serviceCache = new ServiceCache();
        $expireIn = $serviceCache->expireIn();

        // Valida se o resultado é um inteiro
        $this->assertIsInt($expireIn);

        $this->assertSame(
            intval(getConfigData(
                path:'cache/config/expire_in'
            )),
            $expireIn
        );

    }

}
