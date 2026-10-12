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
        Schema::table('catalog_product', function (Blueprint $table) {
            $table->foreign(['brand_id'], 'FK_BRAND')->references(['brand_id'])->on('catalog_product_brands')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['attribute_set_id'], 'FK_CATALOG_ATTRIBUTE_SET')->references(['attribute_set_id'])->on('eav_attributes_set')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['status_id'], 'FK_PRODUCT_STATUS')->references(['status_id'])->on('catalog_product_status')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catalog_product', function (Blueprint $table) {
            $table->dropForeign('FK_BRAND');
            $table->dropForeign('FK_CATALOG_ATTRIBUTE_SET');
            $table->dropForeign('FK_PRODUCT_STATUS');
        });
    }
};
