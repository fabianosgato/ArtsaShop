<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ReviewLike
 * 
 * @property int $review_id
 * @property int $customer_id
 * @property Carbon $created_at
 * 
 * @property CustomerEntity $customer_entity
 * @property Review $review
 *
 * @package App\Models
 */
class ReviewLike extends Model
{
	protected $table = 'review_likes';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'review_id' => 'int',
		'customer_id' => 'int'
	];

	public function customer_entity()
	{
		return $this->belongsTo(CustomerEntity::class, 'customer_id');
	}

	public function review()
	{
		return $this->belongsTo(Review::class);
	}
}
