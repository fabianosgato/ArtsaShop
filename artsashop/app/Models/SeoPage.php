<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SeoPageData
 *
 * @property int $seo_page_id
 * @property string $path
 * @property string|null $object
 * @property string|null $object_id
 * @property string|null $robot_index
 * @property string|null $robot_follow
 * @property string|null $canonical_url
 * @property string|null $title
 * @property string|null $title_source
 * @property string|null $description
 * @property string|null $description_source
 * @property string $change_frequency
 * @property float $priority
 * @property string|null $schema
 * @property string|null $focus_keyword
 * @property string|null $tags
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|SeoLinkTag[] $seo_link_tags
 * @property Collection|SeoPageImage[] $seo_page_images
 * @property Collection|SeoPageMetaTag[] $seo_page_meta_tags
 *
 * @package App\Models
 */
class SeoPage extends Model
{
	protected $table = 'seo_pages';
	protected $primaryKey = 'seo_page_id';

	protected $casts = [
		'priority' => 'float'
	];

	protected $fillable = [
		'path',
		'object',
		'object_id',
		'robot_index',
		'robot_follow',
		'canonical_url',
		'title',
		'title_source',
		'description',
		'description_source',
		'change_frequency',
		'priority',
		'schema',
		'focus_keyword',
		'tags'
	];

	public function seo_link_tags()
	{
		return $this->hasMany(SeoLinkTag::class);
	}

	public function seo_page_images()
	{
		return $this->hasMany(SeoPageImage::class);
	}

	public function seo_page_meta_tags()
	{
		return $this->hasMany(SeoPageMetaTag::class);
	}

    public function metaTags()
    {
        return $this->hasMany(
            SeoPageMetaTag::class,
            'seo_page_id',
            'seo_page_id'
        );
    }

}
