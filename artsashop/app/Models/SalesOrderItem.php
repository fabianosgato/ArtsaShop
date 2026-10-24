<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesOrderItem
 * 
 * @property int $item_id
 * @property int $order_id
 * @property int $product_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $product_sku
 * @property string $product_name
 * @property float $product_weight
 * @property float $qty_ordered
 * @property string|null $detail
 * @property float $price
 * @property float $base_price
 * @property float|null $original_price
 * @property float|null $tax_percent
 * @property float|null $tax_amount
 * @property float|null $base_tax_amount
 * @property float|null $tax_invoiced
 * @property float|null $base_tax_invoiced
 * @property float|null $discount_percent
 * @property float|null $discount_amount
 * @property float $row_total
 * @property float $row_invoiced
 * @property float|null $row_weight
 * 
 * @property SalesOrder $sales_order
 *
 * @package App\Models
 */
class SalesOrderItem extends Model
{
	protected $table = 'sales_order_item';
	protected $primaryKey = 'item_id';

	protected $casts = [
		'order_id' => 'int',
		'product_id' => 'int',
		'product_weight' => 'float',
		'qty_ordered' => 'float',
		'price' => 'float',
		'base_price' => 'float',
		'original_price' => 'float',
		'tax_percent' => 'float',
		'tax_amount' => 'float',
		'base_tax_amount' => 'float',
		'tax_invoiced' => 'float',
		'base_tax_invoiced' => 'float',
		'discount_percent' => 'float',
		'discount_amount' => 'float',
		'row_total' => 'float',
		'row_invoiced' => 'float',
		'row_weight' => 'float'
	];

	protected $fillable = [
		'order_id',
		'product_id',
		'product_sku',
		'product_name',
		'product_weight',
		'qty_ordered',
		'detail',
		'price',
		'base_price',
		'original_price',
		'tax_percent',
		'tax_amount',
		'base_tax_amount',
		'tax_invoiced',
		'base_tax_invoiced',
		'discount_percent',
		'discount_amount',
		'row_total',
		'row_invoiced',
		'row_weight'
	];

	public function sales_order()
	{
		return $this->belongsTo(SalesOrder::class, 'order_id');
	}
}
