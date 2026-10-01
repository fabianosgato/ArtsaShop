<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Idea\Framework\Seo\Contracts\SeoAware;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CmsPage
 *
 * @property int $page_id
 * @property string $title
 * @property string|null $seo_meta_description
 * @property string $seo_page_title
 * @property string|null $content
 * @property string $slug_key
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class CmsPage extends Model implements SeoAware
{
	protected $table = 'cms_page';
	protected $primaryKey = 'page_id';

	protected $casts = [
		'is_active' => 'bool'
	];

	protected $fillable = [
		'title',
		'seo_meta_description',
		'seo_page_title',
		'content',
		'slug_key',
		'is_active'
	];

    public function getSeoObject(): string
    {
        return 'cms';
    }

    public function getSeoObjectId(): string|int
    {
        return $this->page_id;
    }
}
