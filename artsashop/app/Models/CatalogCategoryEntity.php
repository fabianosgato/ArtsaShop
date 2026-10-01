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
 * Class CatalogCategoryEntity
 *
 * @property int $entity_id
 * @property int $parent_id
 * @property string $category
 * @property string $slug_key
 * @property int $level
 * @property string $category_path
 * @property bool $has_products
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Collection|CatalogCategoryProduct[] $catalog_category_products
 * @property Collection|EavAttributesCategory[] $eav_attributes_categories
 *
 * @package App\Models
 */
class CatalogCategoryEntity extends Model implements SeoAware
{
	protected $table = 'catalog_category_entity';
	protected $primaryKey = 'entity_id';

	protected $casts = [
		'parent_id' => 'int',
		'level' => 'int',
		'has_products' => 'bool'
	];

	protected $fillable = [
		'parent_id',
		'category',
		'slug_key',
		'level',
		'category_path',
		'has_products'
	];

    public function catalog_category_products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CatalogCategoryProduct::class, 'category_id');
    }

    public function eav_attributes_categories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EavAttributesCategory::class, 'eav_category_products_id');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function getSeoObject(): string
    {
        return 'category';
    }

    public function getSeoObjectId(): string|int
    {
        return $this->entity_id;
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CatalogCategoryEntity::class, 'parent_id')
            ->orderBy('category');
    }

    public function products()
    {
        return $this->belongsToMany(
            CatalogProduct::class,
            'catalog_category_product',
            'category_id',
            'product_id'
        );
    }

    public function childrenRecursive()
    {
        return $this->children()
            ->where('has_products', true)
            ->with('childrenRecursive');
    }

    public function hasChildren()
    {
        dd($this->children);

    }

}
