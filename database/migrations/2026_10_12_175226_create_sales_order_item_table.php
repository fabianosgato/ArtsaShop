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
        Schema::create('sales_order_item', function (Blueprint $table) {
            $table->increments('item_id')->comment('Item ID');
            $table->integer('order_id')->index('sales_order_item_order_id')->comment('Order ID');
            $table->integer('product_id')->comment('Product ID');
            $table->dateTime('created_at')->comment('Created At');
            $table->dateTime('updated_at')->comment('Updated At');
            $table->string('product_sku')->comment('Sku');
            $table->string('product_name')->comment('Name');
            $table->decimal('product_weight', 12, 4)->default(0)->comment('Weight');
            $table->decimal('qty_ordered', 12, 4)->default(0)->comment('Quantidade comprada');
            $table->text('detail')->nullable()->comment('Description');
            $table->decimal('price', 12, 4)->default(0)->comment('Price');
            $table->decimal('base_price', 12, 4)->default(0)->comment('Base Price');
            $table->decimal('original_price', 12, 4)->nullable()->comment('Original Price');
            $table->decimal('tax_percent', 12, 4)->nullable()->default(0)->comment('Tax Percent');
            $table->decimal('tax_amount', 20, 4)->nullable()->default(0)->comment('Tax Amount');
            $table->decimal('base_tax_amount', 20, 4)->nullable()->default(0)->comment('Base Tax Amount');
            $table->decimal('tax_invoiced', 20, 4)->nullable()->default(0)->comment('Tax Invoiced');
            $table->decimal('base_tax_invoiced', 20, 4)->nullable()->default(0)->comment('Base Tax Invoiced');
            $table->decimal('discount_percent', 12, 4)->nullable()->default(0)->comment('Discount Percent');
            $table->decimal('discount_amount', 20, 4)->nullable()->default(0)->comment('Discount Amount');
            $table->decimal('row_total', 20, 4)->default(0)->comment('Row Total');
            $table->decimal('row_invoiced', 20, 4)->default(0)->comment('Row Invoiced');
            $table->decimal('row_weight', 12, 4)->nullable()->default(0)->comment('Row Weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_item');
    }
};
