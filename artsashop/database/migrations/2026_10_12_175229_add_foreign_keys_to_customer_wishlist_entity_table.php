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
        Schema::table('customer_wishlist_entity', function (Blueprint $table) {
            $table->foreign(['customer_id'], 'FK_CUSTOMER_FAVORITES')->references(['customer_id'])->on('customer_entity')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['product_id'], 'FK_PRODUCT_FAVORITE')->references(['product_id'])->on('catalog_product')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_wishlist_entity', function (Blueprint $table) {
            $table->dropForeign('FK_CUSTOMER_FAVORITES');
            $table->dropForeign('FK_PRODUCT_FAVORITE');
        });
    }
};
