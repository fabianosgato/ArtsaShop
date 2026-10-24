<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesOrderQuoteItemRepository
 *
 * @property int $item_id
 * @property int $quote_id
 * @property int $product_id
 * @property float $price
 * @property int $qty
 * @property float $subtotal
 * @property array $product_snapshot
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property SalesOrderQuote $sales_order_quote
 *
 * @package App\Models
 */
class SalesOrderQuoteItem extends Model
{
	protected $table = 'sales_order_quote_item';
	protected $primaryKey = 'item_id';

	protected $casts = [
		'quote_id' => 'int',
		'product_id' => 'int',
		'price' => 'float',
		'qty' => 'int',
		'subtotal' => 'float',
		'product_snapshot' => 'json'
	];

	protected $fillable = [
		'quote_id',
		'product_id',
		'price',
		'qty',
		'subtotal',
		'product_snapshot'
	];

	public function sales_order_quote()
	{
		return $this->belongsTo(SalesOrderQuote::class, 'quote_id');
	}
}
