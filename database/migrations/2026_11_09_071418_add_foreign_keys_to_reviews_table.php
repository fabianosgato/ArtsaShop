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
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreign(['customer_id'], 'FK_REVIEWS_CUSTOMER_ID')->references(['customer_id'])->on('customer_entity')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['entity_id'], 'FK_REVIEWS_ENTITY_ID')->references(['entity_id'])->on('review_entity')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['store_id'], 'FK_REVIEWS_STORE_ID')->references(['store_id'])->on('sys_store')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign('FK_REVIEWS_CUSTOMER_ID');
            $table->dropForeign('FK_REVIEWS_ENTITY_ID');
            $table->dropForeign('FK_REVIEWS_STORE_ID');
        });
    }
};
