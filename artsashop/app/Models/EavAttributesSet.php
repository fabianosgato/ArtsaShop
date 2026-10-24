<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EavAttributesSet
 * 
 * @property int $attribute_set_id
 * @property string $attribute_set_key
 * @property string $attribute_set_name
 * @property string|null $stemming_words
 * @property int $product_qty
 * @property int $product_qty_stock
 * @property int $product_qty_disable
 * @property int $product_qty_excluded
 * @property bool $is_default
 * @property bool|null $is_category
 * @property bool $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|CatalogProduct[] $catalog_products
 * @property Collection|CatalogProductAttribute[] $catalog_product_attributes
 * @property Collection|EavAttributesCategory[] $eav_attributes_categories
 * @property Collection|EavEntityAttribute[] $eav_entity_attributes
 * @property Collection|EavEntityAttributeOption[] $eav_entity_attribute_options
 *
 * @package App\Models
 */
class EavAttributesSet extends Model
{
	protected $table = 'eav_attributes_set';
	protected $primaryKey = 'attribute_set_id';

	protected $casts = [
		'product_qty' => 'int',
		'product_qty_stock' => 'int',
		'product_qty_disable' => 'int',
		'product_qty_excluded' => 'int',
		'is_default' => 'bool',
		'is_category' => 'bool',
		'status' => 'bool'
	];

	protected $fillable = [
		'attribute_set_key',
		'attribute_set_name',
		'stemming_words',
		'product_qty',
		'product_qty_stock',
		'product_qty_disable',
		'product_qty_excluded',
		'is_default',
		'is_category',
		'status'
	];

	public function catalog_products()
	{
		return $this->hasMany(CatalogProduct::class, 'attribute_set_id');
	}

	public function catalog_product_attributes()
	{
		return $this->hasMany(CatalogProductAttribute::class, 'attribute_set_id');
	}

	public function eav_attributes_categories()
	{
		return $this->hasMany(EavAttributesCategory::class, 'eav_attribute_set_id');
	}

	public function eav_entity_attributes()
	{
		return $this->hasMany(EavEntityAttribute::class, 'attribute_set_id');
	}

	public function eav_entity_attribute_options()
	{
		return $this->hasMany(EavEntityAttributeOption::class, 'attribute_set_id');
	}
}
