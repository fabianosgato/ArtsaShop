<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatalogProductTag
 * 
 * @property int $tag_id
 * @property string $tag_name
 * @property string $slug_key
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|CatalogProductTagsEntity[] $catalog_product_tags_entities
 *
 * @package App\Models
 */
class CatalogProductTag extends Model
{
	protected $table = 'catalog_product_tags';
	protected $primaryKey = 'tag_id';

	protected $fillable = [
		'tag_name',
		'slug_key'
	];

	public function catalog_product_tags_entities()
	{
		return $this->hasMany(CatalogProductTagsEntity::class, 'tag_id');
	}
}
