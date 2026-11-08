<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EavAttributesCategory
 *
 * @property int $eav_attribute_set_id
 * @property int $eav_category_products_id
 *
 * @property EavAttributesSet $eav_attributes_set
 * @property CatalogCategoryEntity $catalog_category_entity
 *
 * @package App\Models
 */
class EavAttributesCategory extends Model
{
	protected $table = 'eav_attributes_category';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'eav_attribute_set_id' => 'int',
		'eav_category_products_id' => 'int'
	];

    protected $fillable = [
        'eav_attribute_set_id',
        'eav_category_products_id'
    ];

	public function eav_attributes_set()
	{
		return $this->belongsTo(EavAttributesSet::class, 'eav_attribute_set_id');
	}

	public function catalog_category_entity()
	{
		return $this->belongsTo(CatalogCategoryEntity::class, 'eav_category_products_id');
	}
}
