<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
 * 
 * @property int $review_id
 * @property int $entity_id
 * @property int $entity_pk_value
 * @property int $customer_id
 * @property int $store_id
 * @property int $status_id
 * @property string $nickname
 * @property string $title
 * @property string $detail
 * @property int $rating
 * @property int $likes_count
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * 
 * @property CustomerEntity $customer_entity
 * @property ReviewEntity $review_entity
 * @property SysStore $sys_store
 * @property Collection|ReviewLike[] $review_likes
 *
 * @package App\Models
 */
class Review extends Model
{
	protected $table = 'reviews';
	protected $primaryKey = 'review_id';

	protected $casts = [
		'entity_id' => 'int',
		'entity_pk_value' => 'int',
		'customer_id' => 'int',
		'store_id' => 'int',
		'status_id' => 'int',
		'rating' => 'int',
		'likes_count' => 'int'
	];

	protected $fillable = [
		'entity_id',
		'entity_pk_value',
		'customer_id',
		'store_id',
		'status_id',
		'nickname',
		'title',
		'detail',
		'rating',
		'likes_count'
	];

	public function customer_entity()
	{
		return $this->belongsTo(CustomerEntity::class, 'customer_id');
	}

	public function review_entity()
	{
		return $this->belongsTo(ReviewEntity::class, 'entity_id');
	}

	public function sys_store()
	{
		return $this->belongsTo(SysStore::class, 'store_id');
	}

	public function review_likes()
	{
		return $this->hasMany(ReviewLike::class);
	}
}
