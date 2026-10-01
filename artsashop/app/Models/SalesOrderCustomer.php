<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesOrderCustomer
 * 
 * @property int $entity_id
 * @property int $order_id
 * @property int $customer_id
 * 
 * @property CustomerEntity $customer_entity
 * @property SalesOrder $sales_order
 *
 * @package App\Models
 */
class SalesOrderCustomer extends Model
{
	protected $table = 'sales_order_customer';
	protected $primaryKey = 'entity_id';
	public $timestamps = false;

	protected $casts = [
		'order_id' => 'int',
		'customer_id' => 'int'
	];

	protected $fillable = [
		'order_id',
		'customer_id'
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
