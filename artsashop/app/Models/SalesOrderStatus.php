<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesOrderStatus
 * 
 * @property int $status_id
 * @property string $status
 * @property string $label
 * @property string|null $color
 * @property bool $is_enabled
 * @property int $ordination
 *
 * @package App\Models
 */
class SalesOrderStatus extends Model
{
	protected $table = 'sales_order_status';
	protected $primaryKey = 'status_id';
	public $timestamps = false;

	protected $casts = [
		'is_enabled' => 'bool',
		'ordination' => 'int'
	];

	protected $fillable = [
		'status',
		'label',
		'color',
		'is_enabled',
		'ordination'
	];
}
