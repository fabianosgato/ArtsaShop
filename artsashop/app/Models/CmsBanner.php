<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CmsBanner
 * 
 * @property int $banner_id
 * @property string|null $store_id
 * @property string $banner_type
 * @property string $banner_local
 * @property string|null $image
 * @property string|null $image_alt
 * @property string $title
 * @property string|null $content
 * @property string|null $banner_url
 * @property int|null $banner_order
 * @property int $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class CmsBanner extends Model
{
	protected $table = 'cms_banners';
	protected $primaryKey = 'banner_id';

	protected $casts = [
		'banner_order' => 'int',
		'is_active' => 'int'
	];

	protected $fillable = [
		'store_id',
		'banner_type',
		'banner_local',
		'image',
		'image_alt',
		'title',
		'content',
		'banner_url',
		'banner_order',
		'is_active'
	];
}
