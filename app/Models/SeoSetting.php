<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SeoSetting
 * 
 * @property int $seo_setting_id
 * @property string|null $label
 * @property string $key
 * @property string|null $value
 * @property string|null $description
 * @property string $status
 * @property string|null $group
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SeoSetting extends Model
{
	protected $table = 'seo_settings';
	protected $primaryKey = 'seo_setting_id';

	protected $fillable = [
		'label',
		'key',
		'value',
		'description',
		'status',
		'group'
	];
}
