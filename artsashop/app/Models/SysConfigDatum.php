<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SysConfigDatum
 * 
 * @property int $config_id
 * @property string $label
 * @property string $path
 * @property string|null $value
 * @property string|null $note
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class SysConfigDatum extends Model
{
	protected $table = 'sys_config_data';
	protected $primaryKey = 'config_id';

	protected $fillable = [
		'label',
		'path',
		'value',
		'note'
	];
}
