<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Idea\Framework\Seo\Contracts\SeoAware;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CatalogProduct
 *
 * @property int $product_id
 * @property int $attribute_set_id
 * @property int $brand_id
 * @property int $status_id
 * @property string $sku
 * @property string|null $ean
 * @property string $name
 * @property string $description
 * @property string $short_description
 * @property string $slug_key
 * @property string|null $image
 * @property string|null $thumbnail
 * @property string|null $video_url
 * @property int $qty
 * @property float $weight
 * @property float $volume_weight
 * @property float $height
 * @property float $width
 * @property float $length
 * @property bool $is_removed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property CatalogProductBrand $catalog_product_brand
 * @property EavAttributesSet $eav_attributes_set
 * @property CatalogProductStatus $catalog_product_status
 * @property Collection|CatalogCategoryProduct[] $catalog_category_products
 * @property Collection|CatalogProductAttribute[] $catalog_product_attributes
 * @property Collection|CatalogProductMedia[] $catalog_product_media
 * @property Collection|CatalogProductPrice[] $catalog_product_prices
 * @property CatalogProductQueue|null $catalog_product_queue
 * @property Collection|CatalogProductStore[] $catalog_product_stores
 * @property Collection|CustomerWishlistEntity[] $customer_wishlist_entities
 *
 * @package App\Models
 */
class CatalogProduct extends Model implements SeoAware
{
	protected $table = 'catalog_product';
	protected $primaryKey = 'product_id';

	protected $casts = [
		'attribute_set_id' => 'int',
		'brand_id' => 'int',
		'status_id' => 'int',
		'qty' => 'int',
		'weight' => 'float',
		'volume_weight' => 'float',
		'height' => 'float',
		'width' => 'float',
		'length' => 'float',
		'is_removed' => 'bool'
	];

	protected $fillable = [
		'attribute_set_id',
		'brand_id',
		'status_id',
		'sku',
		'ean',
		'name',
		'description',
		'short_description',
		'slug_key',
		'image',
		'thumbnail',
		'video_url',
		'qty',
		'weight',
		'volume_weight',
		'height',
		'width',
		'length',
		'is_excluded'
	];

    public function stores()
    {
        return $this->belongsToMany(
            SysStore::class,
            'catalog_product_store',
            'product_id',
            'store_id'
        );
    }

    protected static function booted()
    {
        static::addGlobalScope('store', function (Builder $builder) {

            // Admin, API, Jobs → não filtrar
            if (!app()->bound('currentStore')) {
                return;
            }

            $store = app('currentStore');

            // Segurança extra
            if (!$store || !$store->store_id) {
                return;
            }

            $builder->whereExists(function ($q) use ($store) {
                $q->selectRaw(1)
                    ->from('catalog_product_store')
                    ->whereColumn(
                        'catalog_product_store.product_id',
                        'catalog_product.product_id'
                    )
                    ->where('catalog_product_store.store_id', $store->store_id);
            });
        });
    }

    public function tags()
    {
        return $this->belongsToMany(
            CatalogProductTag::class,
            'catalog_product_tags_entity',
            'catalog_product_tags_entity.product_id',
            'catalog_product_tags_entity.tag_id'
        );
    }

    public function catalog_product_brand()
	{
		return $this->belongsTo(CatalogProductBrand::class, 'brand_id');
	}

	public function eav_attributes_set()
	{
		return $this->belongsTo(EavAttributesSet::class, 'attribute_set_id');
	}

	public function catalog_product_status()
	{
		return $this->belongsTo(CatalogProductStatus::class, 'status_id');
	}

	public function catalog_category_products()
	{
		return $this->hasMany(CatalogCategoryProduct::class, 'product_id');
	}

	public function catalog_product_attributes()
	{
		return $this->hasMany(CatalogProductAttribute::class, 'product_id');
	}

	public function catalog_product_media()
	{
		return $this->hasMany(CatalogProductMedia::class, 'product_id');
	}

	public function catalog_product_prices()
	{
		return $this->hasMany(CatalogProductPrice::class, 'product_id');
	}

	public function catalog_product_queue()
	{
		return $this->hasOne(CatalogProductQueue::class, 'product_id');
	}

	public function catalog_product_stores()
	{
		return $this->hasMany(CatalogProductStore::class, 'product_id');
	}

	public function customer_wishlist_entities()
	{
		return $this->hasMany(CustomerWishlistEntity::class, 'product_id');
	}

    public function getSeoObject(): string
    {
        return 'product';
    }

    public function getSeoObjectId(): string|int
    {
        return $this->product_id;
    }
}
