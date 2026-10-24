<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesOrderQuoteAddress
 * 
 * @property int $address_id
 * @property int $quote_id
 * @property string|null $address_type
 * @property string|null $street
 * @property string|null $neighborhood
 * @property string|null $complement
 * @property string|null $number
 * @property string|null $city
 * @property string|null $region
 * @property string|null $postcode
 * @property string|null $cellphone
 * @property string|null $telephone
 * @property string|null $recipient_name
 * @property int|null $save_in_address_book
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property SalesOrderQuote $sales_order_quote
 *
 * @package App\Models
 */
class SalesOrderQuoteAddress extends Model
{
	protected $table = 'sales_order_quote_address';
	protected $primaryKey = 'address_id';

	protected $casts = [
		'quote_id' => 'int',
		'save_in_address_book' => 'int'
	];

	protected $fillable = [
		'quote_id',
		'address_type',
		'street',
		'neighborhood',
		'complement',
		'number',
		'city',
		'region',
		'postcode',
		'cellphone',
		'telephone',
		'recipient_name',
		'save_in_address_book'
	];

	public function sales_order_quote()
	{
		return $this->belongsTo(SalesOrderQuote::class, 'quote_id');
	}
}
