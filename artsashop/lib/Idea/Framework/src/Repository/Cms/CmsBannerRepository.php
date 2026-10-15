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

namespace Idea\Framework\Repository\Cms;

use App\Models\CmsBanner;
use Idea\Framework\Repository\AbstractRepository;

class CmsBannerRepository extends AbstractRepository
{

    protected static $model = CmsBanner::class;

    public static function updateOrCreate(?int $id, array $values = []): CmsBanner
    {
        return self::getData()->updateOrCreate(
            attributes: [
                'banner_id' => $id
            ],
            values: $values
        );
    }

}
