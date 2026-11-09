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
        Schema::create('catalog_product_prices', function (Blueprint $table) {
            $table->integer('price_id', true);
            $table->integer('product_id')->index('idx_catalog_product_prices');
            $table->decimal('price', 12, 4)->index('idx_price');
            $table->decimal('final_price', 12, 4)->nullable()->index('idx_promo_price');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_product_prices');
    }
};
