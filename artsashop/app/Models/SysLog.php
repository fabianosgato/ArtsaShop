<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SysLog
 * 
 * @property int $entity_id
 * @property string|null $module
 * @property string|null $type
 * @property string|null $log
 * @property Carbon $created
 *
 * @package App\Models
 */
class SysLog extends Model
{
	protected $table = 'sys_logs';
	protected $primaryKey = 'entity_id';
	public $timestamps = false;

	protected $casts = [
		'created' => 'datetime'
	];

	protected $fillable = [
		'module',
		'type',
		'log',
		'created'
	];
}
