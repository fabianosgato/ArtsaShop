<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CatalogProductTagsEntity
 * 
 * @property int $entity_id
 * @property int $tag_id
 * @property int $product_id
 * 
 * @property CatalogProductTag $catalog_product_tag
 * @property CatalogProduct $catalog_product
 *
 * @package App\Models
 */
class CatalogProductTagsEntity extends Model
{
	protected $table = 'catalog_product_tags_entity';
	protected $primaryKey = 'entity_id';
	public $timestamps = false;

	protected $casts = [
		'tag_id' => 'int',
		'product_id' => 'int'
	];

	protected $fillable = [
		'tag_id',
		'product_id'
	];

	public function catalog_product_tag()
	{
		return $this->belongsTo(CatalogProductTag::class, 'tag_id');
	}

	public function catalog_product()
	{
		return $this->belongsTo(CatalogProduct::class, 'product_id');
	}
}
