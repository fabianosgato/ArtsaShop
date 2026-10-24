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
        Schema::table('sales_order_quote_customer', function (Blueprint $table) {
            $table->foreign(['customer_id'], 'FK_QUOTE_CUSTOMER_CUSTOMER')->references(['customer_id'])->on('customer_entity')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['quote_id'], 'FK_QUOTE_CUSTOMER_QUOTE')->references(['quote_id'])->on('sales_order_quote')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_order_quote_customer', function (Blueprint $table) {
            $table->dropForeign('FK_QUOTE_CUSTOMER_CUSTOMER');
            $table->dropForeign('FK_QUOTE_CUSTOMER_QUOTE');
        });
    }
};
