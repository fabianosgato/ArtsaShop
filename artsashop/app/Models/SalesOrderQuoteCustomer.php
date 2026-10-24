<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesOrderQuoteCustomer
 * 
 * @property int $entity_id
 * @property int $quote_id
 * @property int $customer_id
 * @property Carbon|null $created_at
 * 
 * @property CustomerEntity $customer_entity
 * @property SalesOrderQuote $sales_order_quote
 *
 * @package App\Models
 */
class SalesOrderQuoteCustomer extends Model
{
	protected $table = 'sales_order_quote_customer';
	protected $primaryKey = 'entity_id';
	public $timestamps = false;

	protected $casts = [
		'quote_id' => 'int',
		'customer_id' => 'int'
	];

	protected $fillable = [
		'quote_id',
		'customer_id'
	];

	public function customer_entity()
	{
		return $this->belongsTo(CustomerEntity::class, 'customer_id');
	}

	public function sales_order_quote()
	{
		return $this->belongsTo(SalesOrderQuote::class, 'quote_id');
	}
}
