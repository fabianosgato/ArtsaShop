<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesOrderPayment
 *
 * @property int $entity_id
 * @property int $order_id
 * @property string|null $method
 * @property string|null $description
 * @property float|null $value
 * @property string $additional_information
 *
 * @property SalesOrder $sales_order
 *
 * @package App\Models
 */
class SalesOrderPayment extends Model
{

	protected $table = 'sales_order_payments';
	protected $primaryKey = 'entity_id';
	public $timestamps = false;

	protected $casts = [
		'order_id' => 'int',
		'value' => 'float'
	];

	protected $fillable = [
		'order_id',
		'method',
		'description',
		'value',
		'additional_information'
	];

	public function sales_order()
	{
		return $this->belongsTo(SalesOrder::class, 'order_id');
	}

}
