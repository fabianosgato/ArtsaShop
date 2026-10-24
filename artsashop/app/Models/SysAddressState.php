<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SysAddressState
 * 
 * @property int $entity_id
 * @property string $uf_initials
 * @property string $uf_description
 *
 * @package App\Models
 */
class SysAddressState extends Model
{
	protected $table = 'sys_address_states';
	protected $primaryKey = 'entity_id';
	public $timestamps = false;

	protected $fillable = [
		'uf_initials',
		'uf_description'
	];
}
