<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CmsBlock
 * 
 * @property int $block_id
 * @property string $title
 * @property string $identifier
 * @property string|null $content
 * @property int $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class CmsBlock extends Model
{
	protected $table = 'cms_block';
	protected $primaryKey = 'block_id';

	protected $casts = [
		'is_active' => 'int'
	];

	protected $fillable = [
		'title',
		'identifier',
		'content',
		'is_active'
	];
}
