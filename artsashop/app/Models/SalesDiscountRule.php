<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesDiscountRule
 * 
 * @property int $rule_id
 * @property string $code
 * @property string $label
 * @property bool $is_active
 * @property string $apply_to
 * @property string $discount_type
 * @property float $discount_value
 * @property string|null $payment_method
 * @property float|null $min_subtotal
 * @property float|null $max_subtotal
 * @property Carbon|null $starts_at
 * @property Carbon|null $ends_at
 * @property int $priority
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SalesDiscountRule extends Model
{
	protected $table = 'sales_discount_rule';
	protected $primaryKey = 'rule_id';

	protected $casts = [
		'is_active' => 'bool',
		'discount_value' => 'float',
		'min_subtotal' => 'float',
		'max_subtotal' => 'float',
		'starts_at' => 'datetime',
		'ends_at' => 'datetime',
		'priority' => 'int'
	];

	protected $fillable = [
		'code',
		'label',
		'is_active',
		'apply_to',
		'discount_type',
		'discount_value',
		'payment_method',
		'min_subtotal',
		'max_subtotal',
		'starts_at',
		'ends_at',
		'priority'
	];
}
