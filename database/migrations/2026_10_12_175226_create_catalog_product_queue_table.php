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
        Schema::create('catalog_product_queue', function (Blueprint $table) {
            $table->integer('product_id')->primary();
            $table->string('product_sku', 50)->index('idx_queue_product_sku');
            $table->longText('product_json')->nullable()->comment('Json do produto vindo por API');
            $table->timestamp('created_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_product_queue');
    }
};
