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
        Schema::create('review_likes', function (Blueprint $table) {
            $table->comment('Customers who liked reviews');
            $table->unsignedBigInteger('review_id')->comment('Review Id');
            $table->integer('customer_id')->index('idx_review_likes_customer_id')->comment('Customer Id');
            $table->timestamp('created_at')->useCurrent()->comment('Like creation date');

            $table->primary(['review_id', 'customer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_likes');
    }
};
