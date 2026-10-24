<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesOrderAddress
 * 
 * @property int $entity_id
 * @property int $order_id
 * @property int $customer_id
 * @property string $customer_name
 * @property string|null $customer_phone
 * @property string $customer_cellphone
 * @property string $postcode
 * @property string $street
 * @property string|null $number
 * @property string|null $region
 * @property string|null $complement
 * @property string $neighborhood
 * @property string|null $country
 * @property string|null $city
 * @property string|null $detail
 * @property string|null $reference
 * @property string $address_type
 * 
 * @property CustomerEntity $customer_entity
 * @property SalesOrder $sales_order
 *
 * @package App\Models
 */
class SalesOrderAddress extends Model
{
	protected $table = 'sales_order_address';
	protected $primaryKey = 'entity_id';
	public $timestamps = false;

	protected $casts = [
		'order_id' => 'int',
		'customer_id' => 'int'
	];

	protected $fillable = [
		'order_id',
		'customer_id',
		'customer_name',
		'customer_phone',
		'customer_cellphone',
		'postcode',
		'street',
		'number',
		'region',
		'complement',
		'neighborhood',
		'country',
		'city',
		'detail',
		'reference',
		'address_type'
	];

	public function customer_entity()
	{
		return $this->belongsTo(CustomerEntity::class, 'customer_id');
	}

	public function sales_order()
	{
		return $this->belongsTo(SalesOrder::class, 'order_id');
	}
}
