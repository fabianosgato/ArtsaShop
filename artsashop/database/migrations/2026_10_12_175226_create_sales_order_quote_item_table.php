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
        Schema::create('sales_order_quote_item', function (Blueprint $table) {
            $table->integer('item_id', true);
            $table->integer('quote_id');
            $table->integer('product_id');
            $table->decimal('price', 12, 4);
            $table->integer('qty');
            $table->decimal('subtotal', 12, 4);
            $table->json('product_snapshot');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();

            $table->unique(['quote_id', 'product_id'], 'uniq_quote_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_quote_item');
    }
};
