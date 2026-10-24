<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SysCache
 * 
 * @property string $key
 * @property string $value
 * @property int $expiration
 *
 * @package App\Models
 */
class SysCache extends Model
{
	protected $table = 'sys_cache';
	protected $primaryKey = 'key';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'expiration' => 'int'
	];

	protected $fillable = [
		'value',
		'expiration'
	];
}
