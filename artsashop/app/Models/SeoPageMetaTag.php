<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SeoPageMetaTag
 *
 * @property int $seo_page_meta_tag_id
 * @property int|null $seo_page_id
 * @property int $seo_meta_tag_id
 * @property string|null $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property SeoMetaTag $seo_meta_tag
 * @property SeoPage|null $seo_page
 *
 * @package App\Models
 */
class SeoPageMetaTag extends Model
{
	protected $table = 'seo_page_meta_tags';
	protected $primaryKey = 'seo_page_meta_tag_id';

	protected $casts = [
		'seo_page_id' => 'int',
		'seo_meta_tag_id' => 'int'
	];

	protected $fillable = [
		'seo_page_id',
		'seo_meta_tag_id',
		'content'
	];

	public function seo_meta_tag()
	{
		return $this->belongsTo(SeoMetaTag::class);
	}

	public function seo_page()
	{
		return $this->belongsTo(SeoPage::class);
	}

    public function metaTagName()
    {
        return $this->hasMany(
            SeoMetaTag::class,
            'seo_meta_tag_id',
            'seo_meta_tag_id'
        );
    }


}
