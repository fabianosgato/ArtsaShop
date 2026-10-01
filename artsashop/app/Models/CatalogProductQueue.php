<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatalogProductQueue
 *
 * @property int $product_id
 * @property string $product_sku
 * @property array|null $product_json
 * @property Carbon|null $created_at
 *
 * @property CatalogProduct $catalog_product
 *
 * @package App\Models
 */
class CatalogProductQueue extends Model
{
	protected $table = 'catalog_product_queue';
	protected $primaryKey = 'product_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int',
		'product_json' => 'json'
	];

	protected $fillable = [
        'product_id',
		'product_sku',
		'product_json'
	];

	public function catalog_product()
	{
		return $this->belongsTo(CatalogProduct::class, 'product_id');
	}
}
