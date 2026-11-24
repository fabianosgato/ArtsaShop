<?php

namespace Database\Factories;

use App\Models\CatalogCategoryEntity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CatalogCategoryEntity>
 */
class CatalogCategoryEntityFactory extends Factory
{
    protected $model = CatalogCategoryEntity::class;

    public function definition(): array
    {
        return [
            'parent_id' => 0,
            'category' => $this->faker->unique()->word(),
            'slug_key' => $this->faker->unique()->slug(),
            'level' => 1,
            'category_path' => $this->faker->unique()->slug(),
            'has_products' => true,
        ];
    }
}
