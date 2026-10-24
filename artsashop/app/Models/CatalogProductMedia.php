<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatalogProductMedia
 * 
 * @property int $media_id
 * @property int $product_id
 * @property string $media_type
 * @property string $media_file
 * @property string $media_url
 * @property int $sort_order
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property CatalogProduct $catalog_product
 *
 * @package App\Models
 */
class CatalogProductMedia extends Model
{
	protected $table = 'catalog_product_media';
	protected $primaryKey = 'media_id';

	protected $casts = [
		'product_id' => 'int',
		'sort_order' => 'int'
	];

	protected $fillable = [
		'product_id',
		'media_type',
		'media_file',
		'media_url',
		'sort_order'
	];

	public function catalog_product()
	{
		return $this->belongsTo(CatalogProduct::class, 'product_id');
	}
}
