<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * Class SysPersonalAccessToken
 *
 * @property int $id
 * @property string $tokenable_type
 * @property int $tokenable_id
 * @property string $name
 * @property string $token
 * @property string|null $abilities
 * @property Carbon|null $last_used_at
 * @property Carbon|null $expires_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class SysPersonalAccessToken extends SanctumPersonalAccessToken
{
    protected $table = 'sys_personal_access_tokens';
}
