<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerWishlistEntity
 * 
 * @property int $wishlist_id
 * @property int $customer_id
 * @property int $product_id
 * 
 * @property CustomerEntity $customer_entity
 * @property CatalogProduct $catalog_product
 *
 * @package App\Models
 */
class CustomerWishlistEntity extends Model
{
	protected $table = 'customer_wishlist_entity';
	protected $primaryKey = 'wishlist_id';
	public $timestamps = false;

	protected $casts = [
		'customer_id' => 'int',
		'product_id' => 'int'
	];

	protected $fillable = [
		'customer_id',
		'product_id'
	];

	public function customer_entity()
	{
		return $this->belongsTo(CustomerEntity::class, 'customer_id');
	}

	public function catalog_product()
	{
		return $this->belongsTo(CatalogProduct::class, 'product_id');
	}
}
