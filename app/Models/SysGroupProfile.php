<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SysGroupProfile
 * 
 * @property int $profile_id
 * @property int $group_id
 * @property int $module_menu_id
 * @property bool $view
 * @property bool $info
 * @property bool $altr
 * @property bool $excl
 * @property bool $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property SysGroup $sys_group
 * @property SysModulesMenu $sys_modules_menu
 *
 * @package App\Models
 */
class SysGroupProfile extends Model
{
	protected $table = 'sys_group_profile';
	protected $primaryKey = 'profile_id';

	protected $casts = [
		'group_id' => 'int',
		'module_menu_id' => 'int',
		'view' => 'bool',
		'info' => 'bool',
		'altr' => 'bool',
		'excl' => 'bool',
		'status' => 'bool'
	];

	protected $fillable = [
		'group_id',
		'module_menu_id',
		'view',
		'info',
		'altr',
		'excl',
		'status'
	];

	public function sys_group()
	{
		return $this->belongsTo(SysGroup::class, 'group_id');
	}

	public function sys_modules_menu()
	{
		return $this->belongsTo(SysModulesMenu::class, 'module_menu_id');
	}
}
