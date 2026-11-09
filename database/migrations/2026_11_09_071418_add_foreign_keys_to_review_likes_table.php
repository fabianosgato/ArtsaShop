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
        Schema::table('review_likes', function (Blueprint $table) {
            $table->foreign(['customer_id'], 'FK_REVIEW_LIKES_CUSTOMER_ID')->references(['customer_id'])->on('customer_entity')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['review_id'], 'FK_REVIEW_LIKES_REVIEW_ID')->references(['review_id'])->on('reviews')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_likes', function (Blueprint $table) {
            $table->dropForeign('FK_REVIEW_LIKES_CUSTOMER_ID');
            $table->dropForeign('FK_REVIEW_LIKES_REVIEW_ID');
        });
    }
};
