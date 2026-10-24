<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SysMigration
 * 
 * @property int $id
 * @property string $migration
 * @property int $batch
 *
 * @package App\Models
 */
class SysMigration extends Model
{
	protected $table = 'sys_migrations';
	public $timestamps = false;

	protected $casts = [
		'batch' => 'int'
	];

	protected $fillable = [
		'migration',
		'batch'
	];
}
