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
        Schema::create('sales_order_quote', function (Blueprint $table) {
            $table->integer('quote_id', true);
            $table->string('session_id')->index('idx_quote_session');
            $table->string('customer_email')->nullable();
            $table->string('customer_name')->nullable();
            $table->boolean('customer_create_account')->nullable()->default(false);
            $table->integer('total_qty')->default(0);
            $table->boolean('is_active')->default(true)->index('idx_customer_active');
            $table->string('payment_method', 145)->nullable();
            $table->integer('discount_rule_id')->nullable();
            $table->decimal('discount_amount', 12, 4)->nullable()->default(0);
            $table->decimal('shipping_cost', 12, 4);
            $table->decimal('subtotal', 12, 4)->default(0);
            $table->decimal('grand_total', 12, 4)->nullable()->default(0);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();

            $table->index(['customer_email', 'is_active'], 'idx_quote_customer_active');
            $table->index(['session_id', 'is_active'], 'idx_quote_session_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_quote');
    }
};
