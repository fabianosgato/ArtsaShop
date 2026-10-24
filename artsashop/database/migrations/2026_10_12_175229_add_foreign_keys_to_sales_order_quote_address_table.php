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
        Schema::table('sales_order_quote_address', function (Blueprint $table) {
            $table->foreign(['quote_id'], 'FK_ORDER_QUOTE_ADDRESS_QUOTE_ID')->references(['quote_id'])->on('sales_order_quote')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_order_quote_address', function (Blueprint $table) {
            $table->dropForeign('FK_ORDER_QUOTE_ADDRESS_QUOTE_ID');
        });
    }
};
