<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EavAttribute
 * 
 * @property int $attribute_id
 * @property string $attribute_code
 * @property string $attribute_label
 * @property string|null $slug_key
 * @property string|null $note
 * @property bool $is_system
 * @property bool|null $is_global
 * @property bool $is_filterable
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|CatalogProductAttribute[] $catalog_product_attributes
 * @property Collection|EavEntityAttribute[] $eav_entity_attributes
 * @property Collection|EavEntityAttributeOption[] $eav_entity_attribute_options
 *
 * @package App\Models
 */
class EavAttribute extends Model
{
	protected $table = 'eav_attributes';
	protected $primaryKey = 'attribute_id';

	protected $casts = [
		'is_system' => 'bool',
		'is_global' => 'bool',
		'is_filterable' => 'bool'
	];

	protected $fillable = [
		'attribute_code',
		'attribute_label',
		'slug_key',
		'note',
		'is_system',
		'is_global',
		'is_filterable'
	];

	public function catalog_product_attributes()
	{
		return $this->hasMany(CatalogProductAttribute::class, 'attribute_id');
	}

	public function eav_entity_attributes()
	{
		return $this->hasMany(EavEntityAttribute::class, 'attribute_id');
	}

	public function eav_entity_attribute_options()
	{
		return $this->hasMany(EavEntityAttributeOption::class, 'attribute_id');
	}
}
