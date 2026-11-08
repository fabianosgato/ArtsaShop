<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SysPasswordResetToken
 * 
 * @property string $email
 * @property string $token
 * @property Carbon|null $created_at
 *
 * @package App\Models
 */
class SysPasswordResetToken extends Model
{
	protected $table = 'sys_password_reset_tokens';
	protected $primaryKey = 'email';
	public $incrementing = false;
	public $timestamps = false;

	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'token'
	];
}
