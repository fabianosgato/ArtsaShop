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

namespace Idea\Framework\Repository\Reviews;

use App\Models\ReviewEntity;
use Idea\Framework\Repository\AbstractRepository;

class ReviewEntityRepository extends AbstractRepository
{

    protected static $model = ReviewEntity::class;

    public static function getEntity(string $entity): ?ReviewEntity
    {
        $reviewEntity = self::getData()->where(
            column: 'entity_code',
            operator: '=',
            value: $entity
        );

        if ($reviewEntity->exists()) {
            return $reviewEntity->first();
        }

        return null;

    }

}
