<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesOrderQuote
 *
 * @property int $quote_id
 * @property string $session_id
 * @property string|null $customer_email
 * @property string|null $customer_name
 * @property bool|null $customer_create_account
 * @property int $total_qty
 * @property bool $is_active
 * @property string|null $payment_method
 * @property int|null $discount_rule_id
 * @property float|null $discount_amount
 * @property float $shipping_cost
 * @property float $subtotal
 * @property float|null $grand_total
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|SalesOrderQuoteAddress[] $sales_order_quote_addresses
 * @property SalesOrderQuoteCustomer|null $sales_order_quote_customer
 * @property Collection|SalesOrderQuoteItem[] $sales_order_quote_items
 *
 * @package App\Models
 */
class SalesOrderQuote extends Model
{
	protected $table = 'sales_order_quote';
	protected $primaryKey = 'quote_id';

	protected $casts = [
		'customer_create_account' => 'bool',
		'total_qty' => 'int',
		'is_active' => 'bool',
		'discount_rule_id' => 'int',
		'discount_amount' => 'float',
		'shipping_cost' => 'float',
		'subtotal' => 'float',
		'grand_total' => 'float'
	];

	protected $fillable = [
		'session_id',
		'customer_email',
		'customer_name',
		'customer_create_account',
		'total_qty',
		'is_active',
		'payment_method',
		'discount_rule_id',
		'discount_amount',
		'shipping_cost',
		'subtotal',
		'grand_total'
	];

    public function items()
    {
        return $this->hasMany(
            SalesOrderQuoteItem::class,
            'quote_id',
            'quote_id'
        );
    }

    public function customers()
    {
        return $this->hasMany(
            SalesOrderQuoteCustomer::class,
            'quote_id',
            'quote_id'
        );
    }

    public function customerAddresses()
    {
        return $this->hasMany(
            SalesOrderQuoteAddress::class,
            'quote_id',
            'quote_id'
        );
    }

	public function sales_order_quote_addresses()
	{
		return $this->hasMany(SalesOrderQuoteAddress::class, 'quote_id');
	}

	public function sales_order_quote_customer()
	{
		return $this->hasOne(SalesOrderQuoteCustomer::class, 'quote_id');
	}

	public function sales_order_quote_items()
	{
		return $this->hasMany(SalesOrderQuoteItem::class, 'quote_id');
	}
}
