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
