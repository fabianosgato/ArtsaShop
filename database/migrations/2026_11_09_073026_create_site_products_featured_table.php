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
        Schema::create('site_products_featured', function (Blueprint $table) {
            $table->comment('Relação de cada produto do sistema com o bloco referente');
            $table->integer('featured_product_id', true);
            $table->integer('featured_block_id')->index('idx_blocks_featured');
            $table->integer('product_id')->index('idx_block_catalog_product');
            $table->integer('position')->index('idx_position');
            $table->string('product_sku', 40);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_products_featured');
    }
};
