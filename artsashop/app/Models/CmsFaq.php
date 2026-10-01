<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CmsFaq
 * 
 * @property int $faq_id
 * @property string $faq_title
 * @property string $faq_content
 * @property int $sort_order
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class CmsFaq extends Model
{
	protected $table = 'cms_faq';
	protected $primaryKey = 'faq_id';

	protected $casts = [
		'sort_order' => 'int'
	];

	protected $fillable = [
		'faq_title',
		'faq_content',
		'sort_order'
	];
}
