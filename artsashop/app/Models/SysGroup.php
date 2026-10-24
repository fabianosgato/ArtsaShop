<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SysGroup
 * 
 * @property int $group_id
 * @property string $group_name
 * @property bool $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|SysGroupProfile[] $sys_group_profiles
 * @property Collection|SysUser[] $sys_users
 *
 * @package App\Models
 */
class SysGroup extends Model
{
	protected $table = 'sys_group';
	protected $primaryKey = 'group_id';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'group_name',
		'status'
	];

	public function sys_group_profiles()
	{
		return $this->hasMany(SysGroupProfile::class, 'group_id');
	}

	public function sys_users()
	{
		return $this->hasMany(SysUser::class, 'group_id');
	}
}
