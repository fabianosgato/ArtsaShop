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
        Schema::table('catalog_product_tags_entity', function (Blueprint $table) {
            $table->foreign(['tag_id'], 'FK_PRODUCT_TAG')->references(['tag_id'])->on('catalog_product_tags')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['product_id'], 'FK_TAG_PRODUCT')->references(['product_id'])->on('catalog_product')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catalog_product_tags_entity', function (Blueprint $table) {
            $table->dropForeign('FK_PRODUCT_TAG');
            $table->dropForeign('FK_TAG_PRODUCT');
        });
    }
};
