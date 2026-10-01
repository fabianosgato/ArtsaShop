<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SysCarrier
 * 
 * @property int $carrier_id
 * @property string $carrier_name
 * @property int $multiplier
 * @property string $pricing_type
 * @property float|null $weight_cost_kg
 * @property float|null $highest_cost_kg
 * @property bool|null $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class SysCarrier extends Model
{
	protected $table = 'sys_carriers';
	protected $primaryKey = 'carrier_id';

	protected $casts = [
		'multiplier' => 'int',
		'weight_cost_kg' => 'float',
		'highest_cost_kg' => 'float',
		'status' => 'bool'
	];

	protected $fillable = [
		'carrier_name',
		'multiplier',
		'pricing_type',
		'weight_cost_kg',
		'highest_cost_kg',
		'status'
	];
}
