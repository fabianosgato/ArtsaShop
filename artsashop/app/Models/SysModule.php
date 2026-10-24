<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SysModule
 * 
 * @property int $module_id
 * @property string $module_name
 * @property int $module_order
 * @property string $icon
 * @property string $route_prefix
 * @property bool $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|SysModulesMenu[] $sys_modules_menus
 *
 * @package App\Models
 */
class SysModule extends Model
{
	protected $table = 'sys_modules';
	protected $primaryKey = 'module_id';

	protected $casts = [
		'module_order' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'module_name',
		'module_order',
		'icon',
		'route_prefix',
		'status'
	];

	public function sys_modules_menus()
	{
		return $this->hasMany(SysModulesMenu::class, 'module_id');
	}
}
