<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class SysUser
 *
 * @property int $user_id
 * @property int $group_id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property bool $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property SysGroup $sys_group
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    protected $table = 'sys_users';
    protected $primaryKey = 'user_id';

    use HasFactory, Notifiable;

    protected $casts = [
        'group_id' => 'int',
        'email_verified_at' => 'datetime',
        'status' => 'bool'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'group_id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'status'
    ];

    public function sys_group()
    {
        return $this->belongsTo(SysGroup::class, 'group_id');
    }

}
