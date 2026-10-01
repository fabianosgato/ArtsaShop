<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CatalogCategoryProduct
 *
 * @property int $category_id
 * @property int $product_id
 * @property int|null $position
 *
 * @property CatalogCategoryEntity $catalog_category_entity
 * @property CatalogProduct $catalog_product
 *
 * @package App\Models
 */
class CatalogCategoryProduct extends Model
{
	protected $table = 'catalog_category_product';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'category_id' => 'int',
		'product_id' => 'int',
		'position' => 'int'
	];

	protected $fillable = [
        'category_id',
        'product_id',
        'position'
	];

	public function catalog_category_entity()
	{
		return $this->belongsTo(CatalogCategoryEntity::class, 'category_id');
	}

	public function catalog_product()
	{
		return $this->belongsTo(CatalogProduct::class, 'product_id');
	}
}
