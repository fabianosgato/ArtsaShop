<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * Não editar ou acrescentar à este arquivo se você quiser fazer o upgrade para versões
 * mais recentes no futuro.
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */
declare(strict_types=1);

namespace Idea\Framework\Repository\System;

use App\Models\SysUrlRewrite;
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Support\Facades\Log;

class SysUrlRewriteRepository extends AbstractRepository
{

    // Model da classe
    protected static $model = SysUrlRewrite::class;

    /**
     * Retorna a URL pelo Slug
     * @param $slug
     * @return false
     */
    public static function getBySlug($slug)
    {

        // Inicializa a query
        $query = self::loadModel()::query();

        // Filtra pelo Slug
        $query->where(
            column: 'request_path',
            operator: '=',
            value: $slug
        );

        $existing = $query->first();

        if ($existing)
            return $query->first()->toArray();

        return false;

    }

    /**
     * Insere/Atualiza a URL no sistema de ReWrite
     *  Campos esperados em $attributes:
     *  - request_path
     *  - target_path
     *  - target_type
     *  - is_system (default 1)
     *  - options (nullable)
     *
     * @param array $attributes
     * @return void
     */
    public static function saveUrlRewrite(array $attributes): void
    {

        try {

            // Normalização básica
            $requestPath = trim($attributes['request_path'], '/');
            $targetPath  = trim($attributes['target_path'], '/');

            // Valida se existe o RequestPath
            $existingUrls = self::getData()->where(
                column: 'request_path',
                operator: '=',
                value: $requestPath
            );

            // Se existir irá apenas atualizar normalmente
            if ($existingUrls->exists()) {

                $sysUrlRewrite = $existingUrls->first();

                if ($sysUrlRewrite->target_path != $targetPath) {
                    // LOG DE ERRO COMPLETO
                    Log::error('Existem target_path diferentes', [
                        'attributes'  => $attributes,
                        'targetPath'  => $targetPath,
                        'targetPathDb'  => $sysUrlRewrite->target_path,
                    ]);
                }

                self::getData()->find($sysUrlRewrite->url_rewrite_id)->update([
                    'request_path' => $requestPath,
                    'target_path' => $targetPath,
                    'target_type' => $attributes['target_type'],
                    'is_system' => $attributes['is_system'] ?? 1,
                    'options' => $attributes['options'] ?? null
                ]);

            } else {

                // Valida se existe o registrto pelo RequestPath
                $existingUrls = self::getData()->where(
                    column: 'target_path',
                    operator: '=',
                    value: $targetPath
                );

                // Valida se existem URLs do produto na base
                if ($existingUrls->exists()) {

                    foreach ($existingUrls->get() as $url) {

                        // Valida se a URL existente é diferente da nova URL
                        if ($url->request_path !== $requestPath) {

                            // Atualiza o options e adiciona o redirect 301
                            self::getData()->updateOrCreate(
                                attributes: [
                                    'url_rewrite_id' => $url->url_rewrite_id
                                ],
                                values:[
                                    'options' => json_encode(['redirect' => 301]),
                                    'is_system' => 0
                                ]);

                        } else {
                            self::getData()->find($url->url_rewrite_id)->update([
                                'request_path' => $requestPath,
                                'target_path' => $targetPath,
                                'target_type' => $attributes['target_type'],
                                'is_system' => $attributes['is_system'] ?? 1,
                                'options' => $attributes['options'] ?? null
                            ]);

                        }

                    }

                }

                // Não existe → cria a URL
                self::getData()->firstOrCreate([
                    'request_path' => $requestPath,
                    'target_path' => $targetPath,
                    'target_type' => $attributes['target_type'],
                    'is_system' => $attributes['is_system'] ?? 1,
                    'options' => $attributes['options'] ?? null,
                ]);

            }

        } catch (\Throwable $e) {

            // LOG DE ERRO COMPLETO
            Log::error('Erro saveUrlRewrite', [
                'attributes'  => $attributes,
                'requestPath' => $requestPath ?? null,
                'targetPath'  => $targetPath ?? null,
            ]);

        }

    }

    /**
     * Busca a URL unica do sistema
     * @param string $targetPath
     * @return \App\Models\SysUrlRewrite|null
     */
    public static function getCanonicalByTargetPath(string $targetPath): ?SysUrlRewrite
    {
        return self::getData()
            ->where('target_path', $targetPath)
            ->whereNull('options') // canonical = sem redirect
            ->first();
    }

}
