<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Idea\Framework\Seo\Contracts\SeoAware;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SysStore
 *
 * @property int $store_id
 * @property string $code
 * @property string $code_order
 * @property string $host
 * @property string $store_name
 * @property string $layout
 * @property string|null $type
 * @property bool|null $is_default
 * @property int|null $parent_id
 *
 * @package App\Models
 */
class SysStore extends Model implements SeoAware
{
	protected $table = 'sys_store';
	protected $primaryKey = 'store_id';
	public $timestamps = false;

	protected $casts = [
		'is_default' => 'bool',
		'parent_id' => 'int'
	];

	protected $fillable = [
		'code',
		'code_order',
		'host',
		'store_name',
		'layout',
		'type',
		'is_default',
		'parent_id'
	];

    public function getSeoObject(): string
    {
        return 'store';
    }

    public function getSeoObjectId(): string|int
    {
        return $this->store_id;
    }

}
