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

    /**
     * Valida se as tags estão listadas no sistema
     * @param $tags
     * @return array
     */
    private function checkTags($tags): array
    {
        $invalidTags = array_diff(
            $tags,
            array_keys(config('idea.cache.types'))
        );

        if (!empty($invalidTags)) {
            throw new InvalidArgumentException(
                "Tag `$invalidTags[0]` informada não consta na configuração"
            );
        }

        return $tags;

    }

    /**
     * Retorna o tempo de expiração padrão do sistema
     * @return int
     */
    public function defaultExpireIn(): int
    {
        return intval(getConfigData(
            path: 'cache/config/expire_in'
        ));
    }

    /**
     * Retorna o tempo de expiração de um cache
     * @param array $tags
     * @return int
     */
    public function getCacheExpireIn(array $tags): int
    {
        // Retorna a configuração padrão
        $expireIn = $this->defaultExpireIn();

        // Retorna os tipos de cache
        $cacheTypes = config('idea.cache.types');

        foreach ($cacheTypes as $key => $cacheType) {

            // Ignora configurações que não participam deste cache
            if (!in_array($key, $tags)) {
                continue;
            }

            // Quando o valor de expire_in for zero, o cache é eterno
            if ($cacheType['expire_in'] == 0) {
                return 0;
            }

            // Utiliza o maior TTL entre as tags
            if ($expireIn < $cacheType['expire_in']) {
                $expireIn = $cacheType['expire_in'];
            }
        }

        return $expireIn;
    }

    /**
     * Cria caches no sistema
     * @param string $cacheKey
     * @param array $tags
     * @param \Closure $closure
     * @return mixed
     */
    public function remember(
        string  $cacheKey,
        array   $tags,
        Closure $closure
    ): mixed
    {

        // Valida as tags configuradas no sistema
        $tags = $this->checkTags($tags);

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

    /**
     * Limpa o cache de tags
     * @param array $tags
     * @return \Idea\Framework\Services\ServiceCache
     */
    public function forgetByTags(array $tags): static
    {

        // Valida as tags configuradas no sistema
        $tags = $this->checkTags($tags);

        // Realiza o flush do cache
        Cache::tags($tags)->flush();

        return $this;

    }

    /**
     * Limpa o cache de uma Key
     * @param string $key
     * @return \Idea\Framework\Services\ServiceCache
     */
    public function forgetByKey(string $key): static
    {
        // Realiza o flush do cache
        Cache::forget($key);

        return $this;
    }

    /**
     * Limpa o cache uma lista de keys
     * @param array $keys
     * @return \Idea\Framework\Services\ServiceCache
     */
    public function forgetByKeyList(array $keys): static
    {
        foreach ($keys as $key) {
            // Realiza o flush do cache
            Cache::forget($key);

        }

        return $this;

    }

}
