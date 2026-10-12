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
        Schema::create('sales_order_quote_customer', function (Blueprint $table) {
            $table->integer('entity_id', true);
            $table->integer('quote_id')->unique('uk_quote_customer');
            $table->integer('customer_id')->index('fk_quote_customer_customer');
            $table->timestamp('created_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_quote_customer');
    }
};
