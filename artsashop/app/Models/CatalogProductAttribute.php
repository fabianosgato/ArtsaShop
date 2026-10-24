<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CatalogProductAttribute
 * 
 * @property int $relacional_id
 * @property int $attribute_set_id
 * @property int $attribute_id
 * @property int $product_id
 * @property string $attribute_code
 * @property string|null $value
 * @property string|null $serialized_value
 * 
 * @property CatalogProduct $catalog_product
 * @property EavAttribute $eav_attribute
 * @property EavAttributesSet $eav_attributes_set
 *
 * @package App\Models
 */
class CatalogProductAttribute extends Model
{
	protected $table = 'catalog_product_attributes';
	protected $primaryKey = 'relacional_id';
	public $timestamps = false;

	protected $casts = [
		'attribute_set_id' => 'int',
		'attribute_id' => 'int',
		'product_id' => 'int'
	];

	protected $fillable = [
		'attribute_set_id',
		'attribute_id',
		'product_id',
		'attribute_code',
		'value',
		'serialized_value'
	];

	public function catalog_product()
	{
		return $this->belongsTo(CatalogProduct::class, 'product_id');
	}

	public function eav_attribute()
	{
		return $this->belongsTo(EavAttribute::class, 'attribute_id');
	}

	public function eav_attributes_set()
	{
		return $this->belongsTo(EavAttributesSet::class, 'attribute_set_id');
	}
}
