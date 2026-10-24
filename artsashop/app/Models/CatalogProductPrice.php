<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatalogProductPrice
 * 
 * @property int $price_id
 * @property int $product_id
 * @property float $price
 * @property float|null $final_price
 * @property Carbon|null $updated_at
 * 
 * @property CatalogProduct $catalog_product
 *
 * @package App\Models
 */
class CatalogProductPrice extends Model
{
	protected $table = 'catalog_product_prices';
	protected $primaryKey = 'price_id';
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int',
		'price' => 'float',
		'final_price' => 'float'
	];

	protected $fillable = [
		'product_id',
		'price',
		'final_price'
	];

	public function catalog_product()
	{
		return $this->belongsTo(CatalogProduct::class, 'product_id');
	}
}
