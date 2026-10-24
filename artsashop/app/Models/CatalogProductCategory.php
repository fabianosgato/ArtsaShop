<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatalogProductCategory
 * 
 * @property int $entity_id
 * @property int $product_id
 * @property string $category_name
 * @property string $slug_key
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property CatalogProduct $catalog_product
 *
 * @package App\Models
 */
class CatalogProductCategory extends Model
{
	protected $table = 'catalog_product_category';
	protected $primaryKey = 'entity_id';

	protected $casts = [
		'product_id' => 'int'
	];

	protected $fillable = [
		'product_id',
		'category_name',
		'slug_key'
	];

	public function catalog_product()
	{
		return $this->belongsTo(CatalogProduct::class, 'product_id');
	}
}
