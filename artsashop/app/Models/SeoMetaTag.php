<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SeoMetaTag
 * 
 * @property int $seo_meta_tag_id
 * @property string|null $name
 * @property string|null $property
 * @property string $status
 * @property string|null $group
 * @property string $input_type
 * @property string|null $default_value
 * @property string|null $input_placeholder
 * @property string|null $input_label
 * @property string|null $input_info
 * @property string $visibility
 * @property int $ordernation
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|SeoPageMetaTag[] $seo_page_meta_tags
 *
 * @package App\Models
 */
class SeoMetaTag extends Model
{
	protected $table = 'seo_meta_tags';
	protected $primaryKey = 'seo_meta_tag_id';

	protected $casts = [
		'ordernation' => 'int'
	];

	protected $fillable = [
		'name',
		'property',
		'status',
		'group',
		'input_type',
		'default_value',
		'input_placeholder',
		'input_label',
		'input_info',
		'visibility',
		'ordernation'
	];

	public function seo_page_meta_tags()
	{
		return $this->hasMany(SeoPageMetaTag::class);
	}
}
