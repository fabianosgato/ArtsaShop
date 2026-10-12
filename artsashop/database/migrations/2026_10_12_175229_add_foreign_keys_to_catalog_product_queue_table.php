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
        Schema::table('catalog_product_queue', function (Blueprint $table) {
            $table->foreign(['product_id'], 'FK_PRODUCT_ID')->references(['product_id'])->on('catalog_product')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catalog_product_queue', function (Blueprint $table) {
            $table->dropForeign('FK_PRODUCT_ID');
        });
    }
};
