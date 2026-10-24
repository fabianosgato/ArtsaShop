<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EavEntityAttribute
 * 
 * @property int $entity_attribute_id
 * @property int $attribute_set_id
 * @property int $attribute_id
 * @property string|null $frontend_input
 * @property int $sort_order
 * @property bool|null $is_visible
 * @property bool|null $is_searchable
 * @property bool $is_required
 * @property string|null $default_value
 * @property string|null $values
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property EavAttribute $eav_attribute
 * @property EavAttributesSet $eav_attributes_set
 * @property Collection|EavEntityAttributeOption[] $eav_entity_attribute_options
 *
 * @package App\Models
 */
class EavEntityAttribute extends Model
{
	protected $table = 'eav_entity_attribute';
	protected $primaryKey = 'entity_attribute_id';

	protected $casts = [
		'attribute_set_id' => 'int',
		'attribute_id' => 'int',
		'sort_order' => 'int',
		'is_visible' => 'bool',
		'is_searchable' => 'bool',
		'is_required' => 'bool'
	];

	protected $fillable = [
		'attribute_set_id',
		'attribute_id',
		'frontend_input',
		'sort_order',
		'is_visible',
		'is_searchable',
		'is_required',
		'default_value',
		'values'
	];

	public function eav_attribute()
	{
		return $this->belongsTo(EavAttribute::class, 'attribute_id');
	}

	public function eav_attributes_set()
	{
		return $this->belongsTo(EavAttributesSet::class, 'attribute_set_id');
	}

	public function eav_entity_attribute_options()
	{
		return $this->hasMany(EavEntityAttributeOption::class, 'entity_attribute_id');
	}
}
