<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerAddressEntity
 * 
 * @property int $address_id
 * @property int $customer_id
 * @property string $address_type
 * @property string $recipient_name
 * @property string $postcode
 * @property string $street
 * @property string|null $number
 * @property string|null $complement
 * @property string $neighborhood
 * @property string $city
 * @property string $region
 * @property string $country
 * @property string|null $phone
 * @property string|null $cellphone
 * @property bool $is_default_billing
 * @property bool $is_default_shipping
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property CustomerEntity $customer_entity
 *
 * @package App\Models
 */
class CustomerAddressEntity extends Model
{
	protected $table = 'customer_address_entity';
	protected $primaryKey = 'address_id';

	protected $casts = [
		'customer_id' => 'int',
		'is_default_billing' => 'bool',
		'is_default_shipping' => 'bool'
	];

	protected $fillable = [
		'customer_id',
		'address_type',
		'recipient_name',
		'postcode',
		'street',
		'number',
		'complement',
		'neighborhood',
		'city',
		'region',
		'country',
		'phone',
		'cellphone',
		'is_default_billing',
		'is_default_shipping'
	];

	public function customer_entity()
	{
		return $this->belongsTo(CustomerEntity::class, 'customer_id');
	}
}
