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

namespace Idea\Framework\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{

    public static function all(): Collection;

    /**
     * Cria um novo registro (falha se PK duplicada)
     * @param array $attributes
     * @return Model
     */
    public static function create(array $attributes): Model;

    /**
     * Acha pelo attributes ou cria novo (firstOrCreate)
     * @param array $attributes
     * @param array $values
     * @return Model
     */
    public static function firstOrCreate(array $attributes, array $values = []): Model;

    public static function find(int $id): Model|null;

    public static function delete(int $id): int;

    public static function update(int $id, array $attributes): int;

    public static function loadModel(): Model;


}
