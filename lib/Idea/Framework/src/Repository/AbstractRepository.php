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
namespace Idea\Framework\Repository;

use Idea\Framework\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements RepositoryInterface
{
    protected static $model;
    protected static string $tableId;

    public static function loadModel(): Model
    {
        return app(static::$model);
    }

    public static function getData(): \Illuminate\Database\Eloquent\Builder
    {
        return self::loadModel()::query();
    }

    public static function all(): Collection
    {
        return self::loadModel()::all();
    }

    public static function find(int $id): Model|null
    {
        return self::loadModel()::query()->find($id);
    }

    public static function create(array $attributes = [], array $values = []): Model|null
    {
        return self::loadModel()::query()->firstOrCreate(
            attributes: $attributes,
            values:$values
        );
    }

    public static function update(int $id, array $attributes = []): int
    {
        return self::loadModel()::query()
            ->whereKey($id)
            ->update($attributes);
    }

    public static function updateOrCreate(?int $id, array $values = []): ?Model
    {
        return self::getData()->updateOrCreate(
            attributes: [
                self::loadModel()->getKeyName() => $id
            ],
            values: $values
        );

    }

    public static function delete(int $id): int
    {
        return self::loadModel()::destroy($id);
    }

}
