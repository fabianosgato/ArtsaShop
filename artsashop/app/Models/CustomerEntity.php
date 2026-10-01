<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class CustomerEntity
 *
 * @property int $customer_id
 * @property string $customer_name
 * @property string $customer_email
 * @property string $vat_number
 * @property string|null $date_of_birth
 * @property string $customer_passwd
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|CustomerAddressEntity[] $customer_address_entities
 * @property Collection|SalesOrderAddress[] $sales_order_addresses
 * @property Collection|SalesOrderCustomer[] $sales_order_customers
 * @property Collection|SalesOrderQuote[] $sales_order_quotes
 *
 * @package App\Models
 */
class CustomerEntity extends Authenticatable
{

    use Notifiable;

    protected $table = 'customer_entity';
	protected $primaryKey = 'customer_id';

	protected $fillable = [
		'customer_id',
		'customer_name',
		'customer_email',
		'vat_number',
		'date_of_birth',
		'customer_passwd'
	];

    protected $hidden = [
        'customer_passwd',
    ];

    /**
     * Campo de senha customizado
     */
    public function getAuthPassword()
    {
        return $this->customer_passwd;
    }

    /**
     * Campo usado como "username"
     */
    public function getAuthIdentifierName()
    {
        return 'customer_id';
    }

    public function getEmailForPasswordReset()
    {
        return $this->customer_email;
    }

	public function customer_address_entities()
	{
		return $this->hasMany(CustomerAddressEntity::class, 'customer_id');
	}

	public function sales_order_addresses()
	{
		return $this->hasMany(SalesOrderAddress::class, 'customer_id');
	}

	public function sales_order_customers()
	{
		return $this->hasMany(SalesOrderCustomer::class, 'customer_id');
	}

	public function sales_order_quotes()
	{
		return $this->hasMany(SalesOrderQuote::class, 'customer_id');
	}
}
