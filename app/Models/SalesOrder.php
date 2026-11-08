<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesOrder
 * 
 * @property int $order_id
 * @property int $store_id
 * @property int|null $status_id
 * @property string|null $increment_id
 * @property string $store_code
 * @property string $status_type
 * @property string $status_label
 * @property string $status_code
 * @property string $payment_method
 * @property string $payment_description
 * @property float $base_shipping_amount
 * @property float $base_discount_amount
 * @property float $base_subtotal
 * @property float $base_grand_total
 * @property string $canal
 * @property string $remote_ip
 * @property Carbon|null $estimated_delivery_date
 * @property Carbon|null $approved_date
 * @property Carbon|null $delivered_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property SalesOrderStatus|null $sales_order_status
 * @property SysStore $sys_store
 * @property Collection|SalesOrderAddress[] $sales_order_addresses
 * @property Collection|SalesOrderCode[] $sales_order_codes
 * @property Collection|SalesOrderCustomer[] $sales_order_customers
 * @property Collection|SalesOrderItem[] $sales_order_items
 * @property Collection|SalesOrderPayment[] $sales_order_payments
 * @property Collection|SalesOrdersTracking[] $sales_orders_trackings
 *
 * @package App\Models
 */
class SalesOrder extends Model
{
	protected $table = 'sales_orders';
	protected $primaryKey = 'order_id';

	protected $casts = [
		'store_id' => 'int',
		'status_id' => 'int',
		'base_shipping_amount' => 'float',
		'base_discount_amount' => 'float',
		'base_subtotal' => 'float',
		'base_grand_total' => 'float',
		'estimated_delivery_date' => 'datetime',
		'approved_date' => 'datetime',
		'delivered_date' => 'datetime'
	];

	protected $fillable = [
		'store_id',
		'status_id',
		'increment_id',
		'store_code',
		'status_type',
		'status_label',
		'status_code',
		'payment_method',
		'payment_description',
		'base_shipping_amount',
		'base_discount_amount',
		'base_subtotal',
		'base_grand_total',
		'canal',
		'remote_ip',
		'estimated_delivery_date',
		'approved_date',
		'delivered_date'
	];

	public function sales_order_status()
	{
		return $this->belongsTo(SalesOrderStatus::class, 'status_id');
	}

	public function sys_store()
	{
		return $this->belongsTo(SysStore::class, 'store_id');
	}

	public function sales_order_addresses()
	{
		return $this->hasMany(SalesOrderAddress::class, 'order_id');
	}

	public function sales_order_codes()
	{
		return $this->hasMany(SalesOrderCode::class, 'order_id');
	}

	public function sales_order_customers()
	{
		return $this->hasMany(SalesOrderCustomer::class, 'order_id');
	}

	public function sales_order_items()
	{
		return $this->hasMany(SalesOrderItem::class, 'order_id');
	}

	public function sales_order_payments()
	{
		return $this->hasMany(SalesOrderPayment::class, 'order_id');
	}

	public function sales_orders_trackings()
	{
		return $this->hasMany(SalesOrdersTracking::class, 'order_id');
	}
}
