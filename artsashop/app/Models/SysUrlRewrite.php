<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SysUrlRewrite
 * 
 * @property int $url_rewrite_id
 * @property string|null $request_path
 * @property string|null $target_path
 * @property int|null $is_system
 * @property string|null $target_type
 * @property string|null $options
 *
 * @package App\Models
 */
class SysUrlRewrite extends Model
{
	protected $table = 'sys_url_rewrite';
	protected $primaryKey = 'url_rewrite_id';
	public $timestamps = false;

	protected $casts = [
		'is_system' => 'int'
	];

	protected $fillable = [
		'request_path',
		'target_path',
		'is_system',
		'target_type',
		'options'
	];
}
