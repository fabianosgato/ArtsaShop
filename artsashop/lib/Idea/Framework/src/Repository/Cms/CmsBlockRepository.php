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
namespace Idea\Framework\Repository\Cms;

use App\Models\CmsBlock;
use Idea\Framework\Repository\AbstractRepository;

class CmsBlockRepository extends AbstractRepository
{

    protected static $model = CmsBlock::class;

    public static function updateOrCreate(?int $id, array $values = []): CmsBlock
    {
        return self::getData()->updateOrCreate(
            attributes: [
                'block_id' => $id
            ],
            values: $values
        );
    }


}
