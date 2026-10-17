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

use _PHPStan_cb3b7e994\Nette\Neon\Exception;
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

    public function getCacheExpireIn($tags): int
    {

        // Retorna a configuração padrao
        $expireIn = $this->expireIn();

        // Retorna os tipos de cache
        $cacheTypes = config('idea.cache.types');

        foreach ($cacheTypes as $key => $cacheType) {
            if (in_array($key, $tags)) {
                if ($expireIn < $cacheType['expire_in']) {
                    $expireIn = $cacheType['expire_in'];
                }
            }
        }

        return $expireIn;

    }

    public function remember(string $cacheKey, array $tags, Closure $closure)
    {

        if (!empty(array_diff($tags, array_keys(config('idea.cache.types')))))
            throw new Exception('Tag informada não consta na configuração');

        return Cache::tags($tags)
            ->remember(
                key:$cacheKey,
                ttl: $this->getCacheExpireIn($tags),
                callback: $closure
            );
    }

}
