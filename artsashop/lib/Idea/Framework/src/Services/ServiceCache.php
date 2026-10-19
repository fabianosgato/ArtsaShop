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
use InvalidArgumentException;

class ServiceCache
{

    public function defaultExpireIn(): int
    {
        return intval(getConfigData(
            path: 'cache/config/expire_in'
        ));
    }

    public function getCacheExpireIn(array $tags): int
    {

        // Retorna a configuração padrao
        $expireIn = $this->defaultExpireIn();

        // Retorna os tipos de cache
        $cacheTypes = config('idea.cache.types');

        foreach ($cacheTypes as $key => $cacheType) {
            // Quando o valor de expire_in for zero, o cache é eterno
            if($cacheType['expire_in'] == 0){
                return 0;
            }

            if (in_array($key, $tags)) {
                if ($expireIn < $cacheType['expire_in']) {
                    $expireIn = $cacheType['expire_in'];
                }
            }
        }

        return $expireIn;

    }

    public function remember(
        string $cacheKey,
        array $tags,
        Closure $closure
    ) {

        $invalidTags = array_diff(
            $tags,
            array_keys(config('idea.cache.types'))
        );

        if (!empty($invalidTags)) {
            throw new InvalidArgumentException(
                "Tag `{$invalidTags[0]}` informada não consta na configuração"
            );
        }

        // Quando o valor de expire_in for zero, o cache é eterno
        if ($this->getCacheExpireIn($tags) == 0)
            return Cache::tags($tags)
                ->rememberForever(
                    key: $cacheKey,
                    callback: $closure
                );

        return Cache::tags($tags)
            ->remember(
                key: $cacheKey,
                ttl: $this->getCacheExpireIn($tags),
                callback: $closure
            );
    }

}
