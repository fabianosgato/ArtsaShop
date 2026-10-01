<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EavEntityAttributeOption
 * 
 * @property int $eav_attribute_option_id
 * @property int $attribute_set_id
 * @property int $attribute_id
 * @property int $entity_attribute_id
 * @property string $option_name
 * @property string $option_value
 * @property int $sort_order
 * @property bool $is_default
 * 
 * @property EavEntityAttribute $eav_entity_attribute
 * @property EavAttribute $eav_attribute
 * @property EavAttributesSet $eav_attributes_set
 *
 * @package App\Models
 */
class EavEntityAttributeOption extends Model
{
	protected $table = 'eav_entity_attribute_options';
	protected $primaryKey = 'eav_attribute_option_id';
	public $timestamps = false;

	protected $casts = [
		'attribute_set_id' => 'int',
		'attribute_id' => 'int',
		'entity_attribute_id' => 'int',
		'sort_order' => 'int',
		'is_default' => 'bool'
	];

	protected $fillable = [
		'attribute_set_id',
		'attribute_id',
		'entity_attribute_id',
		'option_name',
		'option_value',
		'sort_order',
		'is_default'
	];

	public function eav_entity_attribute()
	{
		return $this->belongsTo(EavEntityAttribute::class, 'entity_attribute_id');
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
