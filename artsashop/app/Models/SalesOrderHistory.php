<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesOrderHistory
 *
 * @property int $history_id
 * @property int $order_id
 * @property bool|null $is_customer_notified
 * @property int $is_visible_on_front
 * @property string|null $comment
 * @property string|null $status_code
 * @property Carbon|null $created_at
 *
 * @property SalesOrder $sales_order
 *
 * @package App\Models
 */
class SalesOrderHistory extends Model
{

	protected $table = 'sales_order_history';
	protected $primaryKey = 'history_id';
	public $timestamps = false;

	protected $casts = [
		'order_id' => 'int',
		'is_customer_notified' => 'bool',
		'is_visible_on_front' => 'int'
	];

	protected $fillable = [
		'order_id',
		'is_customer_notified',
		'is_visible_on_front',
		'comment',
		'status_code'
	];

	public function sales_order()
	{
		return $this->belongsTo(SalesOrder::class, 'order_id');
	}
}
