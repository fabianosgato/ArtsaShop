<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CatalogProductStore
 *
 * @property int $store_id
 * @property int $product_id
 *
 * @property CatalogProduct $catalog_product
 * @property SysStore $sys_store
 *
 * @package App\Models
 */
class CatalogProductStore extends Model
{

	protected $table = 'catalog_product_store';

    public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'store_id' => 'int',
		'product_id' => 'int'
	];

    protected $fillable = [
        'store_id',
        'product_id'
    ];


    public function catalog_product()
	{
		return $this->belongsTo(CatalogProduct::class, 'product_id');
	}

	public function sys_store()
	{
		return $this->belongsTo(SysStore::class, 'store_id');
	}

    public function products()
    {
        return $this->belongsToMany(
            CatalogProduct::class,
            'catalog_product_store',
            'store_id',
            'product_id'
        );
    }

//    protected static function booted()
//    {
//        static::addGlobalScope('store', function (Builder $builder) {
//
//            // API / Console não devem ser afetados
//            if (!app()->bound('currentStore')) {
//                return;
//            }
//
//            $storeId = app('currentStore')->store_id;
//
//            $builder->whereHas('stores', function ($q) use ($storeId) {
//                $q->where('sys_store.store_id', $storeId);
//            });
//
//        });
//
//    }

}
