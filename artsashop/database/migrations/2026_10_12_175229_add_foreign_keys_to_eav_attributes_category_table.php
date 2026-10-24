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
        Schema::table('eav_attributes_category', function (Blueprint $table) {
            $table->foreign(['eav_attribute_set_id'], 'FK_ATTRIBUTESET_ID')->references(['attribute_set_id'])->on('eav_attributes_set')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['eav_category_products_id'], 'FK_CATEGORY_ID')->references(['entity_id'])->on('catalog_category_entity')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eav_attributes_category', function (Blueprint $table) {
            $table->dropForeign('FK_ATTRIBUTESET_ID');
            $table->dropForeign('FK_CATEGORY_ID');
        });
    }
};
