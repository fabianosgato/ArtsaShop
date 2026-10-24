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
        Schema::table('sales_order_payments', function (Blueprint $table) {
            $table->foreign(['order_id'], 'FK_ORDER_PAYMENT')->references(['order_id'])->on('sales_orders')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_order_payments', function (Blueprint $table) {
            $table->dropForeign('FK_ORDER_PAYMENT');
        });
    }
};
