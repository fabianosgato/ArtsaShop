<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SeoLinkTag
 * 
 * @property int $seo_link_tag_id
 * @property int|null $seo_page_id
 * @property string|null $rel
 * @property string|null $href
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property SeoPage|null $seo_page
 *
 * @package App\Models
 */
class SeoLinkTag extends Model
{
	protected $table = 'seo_link_tags';
	protected $primaryKey = 'seo_link_tag_id';

	protected $casts = [
		'seo_page_id' => 'int'
	];

	protected $fillable = [
		'seo_page_id',
		'rel',
		'href',
		'status'
	];

	public function seo_page()
	{
		return $this->belongsTo(SeoPage::class);
	}
}
