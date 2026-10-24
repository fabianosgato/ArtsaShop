<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesOrdersTracking
 * 
 * @property int $tracking_id
 * @property int $order_id
 * @property string $tracking_code
 * @property string $carrier
 * @property string $method
 * @property string $url
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property SalesOrder $sales_order
 *
 * @package App\Models
 */
class SalesOrdersTracking extends Model
{
	protected $table = 'sales_orders_tracking';
	protected $primaryKey = 'tracking_id';

	protected $casts = [
		'order_id' => 'int'
	];

	protected $fillable = [
		'order_id',
		'tracking_code',
		'carrier',
		'method',
		'url'
	];

	public function sales_order()
	{
		return $this->belongsTo(SalesOrder::class, 'order_id');
	}
}
