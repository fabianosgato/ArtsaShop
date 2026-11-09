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
        Schema::table('site_products_featured', function (Blueprint $table) {
            $table->foreign(['product_id'], 'FK_BLOCK_CATALOG_PRODUCT')->references(['product_id'])->on('catalog_product')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['featured_block_id'], 'FK_BLOCKS_FEATURED')->references(['featured_block_id'])->on('site_blocks_featured')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_products_featured', function (Blueprint $table) {
            $table->dropForeign('FK_BLOCK_CATALOG_PRODUCT');
            $table->dropForeign('FK_BLOCKS_FEATURED');
        });
    }
};
