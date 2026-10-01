<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SysModulesMenu
 * 
 * @property int $module_menu_id
 * @property int $module_id
 * @property string $menu_name
 * @property string $access_type
 * @property string|null $menu_link
 * @property int $menu_order
 * @property bool $is_visible
 * @property bool $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property SysModule $sys_module
 * @property Collection|SysGroupProfile[] $sys_group_profiles
 *
 * @package App\Models
 */
class SysModulesMenu extends Model
{
	protected $table = 'sys_modules_menus';
	protected $primaryKey = 'module_menu_id';

	protected $casts = [
		'module_id' => 'int',
		'menu_order' => 'int',
		'is_visible' => 'bool',
		'status' => 'bool'
	];

	protected $fillable = [
		'module_id',
		'menu_name',
		'access_type',
		'menu_link',
		'menu_order',
		'is_visible',
		'status'
	];

	public function sys_module()
	{
		return $this->belongsTo(SysModule::class, 'module_id');
	}

	public function sys_group_profiles()
	{
		return $this->hasMany(SysGroupProfile::class, 'module_menu_id');
	}
}
