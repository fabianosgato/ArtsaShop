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
        Schema::create('reviews', function (Blueprint $table) {
            $table->comment('Reviews');
            $table->bigIncrements('review_id')->comment('Review Id');
            $table->unsignedSmallInteger('entity_id')->comment('Review entity Id');
            $table->unsignedBigInteger('entity_pk_value')->comment('Primary key of the reviewed entity');
            $table->integer('customer_id')->index('idx_reviews_customer_id')->comment('Customer Id');
            $table->unsignedInteger('store_id')->index('idx_reviews_store_id')->comment('Store Id');
            $table->unsignedSmallInteger('status_id')->default(1)->index('idx_reviews_status_id')->comment('Review status Id');
            $table->string('nickname', 128)->comment('Customer nickname at the time of review');
            $table->string('title')->comment('Review title');
            $table->text('detail')->comment('Review content');
            $table->unsignedTinyInteger('rating')->comment('Rating from 1 to 5');
            $table->unsignedInteger('likes_count')->default(0)->comment('Number of likes');
            $table->timestamp('created_at')->useCurrent()->comment('Review creation date');
            $table->timestamp('updated_at')->nullable()->comment('Review last update date');

            $table->index(['entity_id', 'entity_pk_value'], 'idx_reviews_entity');
            $table->index(['entity_id', 'entity_pk_value', 'store_id', 'status_id'], 'idx_reviews_entity_store_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
