<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Idea\Framework\Seo\Contracts\SeoAware;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatalogProductBrand
 *
 * @property int $brand_id
 * @property string $brand_key
 * @property string $brand_name
 * @property string $page_title
 * @property string $content
 * @property string|null $brand_url
 * @property bool $is_salable
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Collection|CatalogProduct[] $catalog_products
 *
 * @package App\Models
 */
class CatalogProductBrand extends Model implements SeoAware
{
	protected $table = 'catalog_product_brands';
	protected $primaryKey = 'brand_id';

	protected $casts = [
		'is_salable' => 'bool'
	];

	protected $fillable = [
		'brand_key',
		'brand_name',
		'page_title',
		'content',
		'brand_url',
		'is_salable'
	];

	public function catalog_products()
	{
		return $this->hasMany(CatalogProduct::class, 'brand_id');
	}

    public function getSeoObject(): string
    {
        return 'brand';
    }

    public function getSeoObjectId(): string|int
    {
        return $this->brand_id;
    }

    public function getDefaultTitle(): string
    {
        return $this->brand_name;
    }

    public function getDefaultDescription()
    {
        return $this->content;
    }

    public function getDefaultNoIndex(): bool
    {
        return false;
    }

    public function getDefaultNoFollow(): bool
    {
        return false;
    }


}
