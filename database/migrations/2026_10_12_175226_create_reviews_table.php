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
            $table->bigInteger('review_id')->comment('Review id');
            $table->integer('product_id')->comment('Product Id');
            $table->integer('customer_id');
            $table->integer('status_id')->comment('Status Id');
            $table->integer('store_id')->comment('Store Id');
            $table->string('nickname');
            $table->text('detail');
            $table->timestamp('created_at')->useCurrentOnUpdate()->nullable()->useCurrent();
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
