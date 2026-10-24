<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesOrderCode
 * 
 * @property int $entity_id
 * @property int $order_id
 * @property string $increment_code
 * 
 * @property SalesOrder $sales_order
 *
 * @package App\Models
 */
class SalesOrderCode extends Model
{
	protected $table = 'sales_order_code';
	protected $primaryKey = 'entity_id';
	public $timestamps = false;

	protected $casts = [
		'order_id' => 'int'
	];

	protected $fillable = [
		'order_id',
		'increment_code'
	];

	public function sales_order()
	{
		return $this->belongsTo(SalesOrder::class, 'order_id');
	}
}
