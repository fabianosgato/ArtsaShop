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
        Schema::table('catalog_product_attributes', function (Blueprint $table) {
            $table->foreign(['product_id'], 'FK_747A21D54584665A')->references(['product_id'])->on('catalog_product')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['attribute_id'], 'FK_747A21D5B6E62EFA')->references(['attribute_id'])->on('eav_attributes')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['attribute_set_id'], 'FK_ATTRIBUTESET_ATTRIBUTE_VALUES')->references(['attribute_set_id'])->on('eav_attributes_set')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catalog_product_attributes', function (Blueprint $table) {
            $table->dropForeign('FK_747A21D54584665A');
            $table->dropForeign('FK_747A21D5B6E62EFA');
            $table->dropForeign('FK_ATTRIBUTESET_ATTRIBUTE_VALUES');
        });
    }
};
