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

namespace Idea\Framework\Repository\Catalog;

use App\Models\CatalogProduct;
use App\Models\CatalogProductCategory;
use Idea\Framework\Repository\AbstractRepository;

class CatalogProductCategoryRepository extends AbstractRepository
{

    protected static $model = CatalogProductCategory::class;

    public static function saveOrUpdate(CatalogProduct $catalogProduct, $attributes): ?CatalogProductCategory
    {

        return self::getData()
            ->updateOrCreate(
                attributes: [
                    'product_id' => $catalogProduct->product_id
                ],
                values: $attributes
            );

    }

}
