<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatalogProductStatus
 * 
 * @property int $status_id
 * @property string $status
 * @property string $status_key
 * 
 * @property Collection|CatalogProduct[] $catalog_products
 *
 * @package App\Models
 */
class CatalogProductStatus extends Model
{
	protected $table = 'catalog_product_status';
	protected $primaryKey = 'status_id';
	public $timestamps = false;

	protected $fillable = [
		'status',
		'status_key'
	];

	public function catalog_products()
	{
		return $this->hasMany(CatalogProduct::class, 'status_id');
	}
}
