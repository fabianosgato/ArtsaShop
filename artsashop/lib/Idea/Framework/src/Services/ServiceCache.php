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

namespace Idea\Framework\Services;

use Closure;
use Illuminate\Support\Facades\Cache;

class ServiceCache
{

    public function expireIn(): int
    {
        return intval(getConfigData(
            path: 'cache/config/expire_in'
        ));
    }

    public function remember(string $cacheKey, array $tags, Closure $closure)
    {
        return Cache::tags($tags)
            ->remember($cacheKey, $this->expireIn(), $closure);
    }




}
