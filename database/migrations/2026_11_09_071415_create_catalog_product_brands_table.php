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
        Schema::create('catalog_product_brands', function (Blueprint $table) {
            $table->integer('brand_id', true);
            $table->string('brand_key')->index('idx_brand_key');
            $table->string('brand_name', 45);
            $table->string('page_title', 45);
            $table->longText('content');
            $table->string('brand_url')->nullable();
            $table->boolean('is_salable');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_product_brands');
    }
};
