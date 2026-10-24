<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SeoPageImage
 * 
 * @property int $seo_page_image_id
 * @property int $seo_page_id
 * @property string|null $src
 * @property string|null $title
 * @property string|null $caption
 * @property string|null $location
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property SeoPage $seo_page
 *
 * @package App\Models
 */
class SeoPageImage extends Model
{
	protected $table = 'seo_page_images';
	protected $primaryKey = 'seo_page_image_id';

	protected $casts = [
		'seo_page_id' => 'int'
	];

	protected $fillable = [
		'seo_page_id',
		'src',
		'title',
		'caption',
		'location'
	];

	public function seo_page()
	{
		return $this->belongsTo(SeoPage::class);
	}
}
