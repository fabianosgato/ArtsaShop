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
        Schema::create('customer_wishlist_entity', function (Blueprint $table) {
            $table->comment('Tabela com os produtos favoritos dos clientes');
            $table->integer('wishlist_id', true);
            $table->integer('customer_id')->index('idx_customer_favorites');
            $table->integer('product_id')->index('idx_product_favorites');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_wishlist_entity');
    }
};
