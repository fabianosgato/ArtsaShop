<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('catalog_category_product', function (Blueprint $table) {
            $table->comment('Catalog Product To Category Linkage Table');
            $table->integer('category_id')->comment('Category ID');
            $table->integer('product_id')->index('idx_catalog_category_product_product_id')->comment('Product ID');
            $table->integer('position')->nullable()->default(0)->comment('Position');

            $table->primary(['category_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_category_product');
    }
};
