<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesShippingStatus
 * 
 * @property int $shipping_status_id
 * @property int|null $bbexp_status_id
 * @property int|null $sales_status_id
 * @property string $descricao_status
 * @property int|null $ordering
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class SalesShippingStatus extends Model
{
	protected $table = 'sales_shipping_status';
	protected $primaryKey = 'shipping_status_id';

	protected $casts = [
		'bbexp_status_id' => 'int',
		'sales_status_id' => 'int',
		'ordering' => 'int'
	];

	protected $fillable = [
		'bbexp_status_id',
		'sales_status_id',
		'descricao_status',
		'ordering'
	];
}
