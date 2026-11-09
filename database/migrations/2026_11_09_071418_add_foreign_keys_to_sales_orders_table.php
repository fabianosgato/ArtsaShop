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
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->foreign(['status_id'], 'FK_ORDERS_STATUS')->references(['status_id'])->on('sales_order_status')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['store_id'], 'FK_ORDERS_STORE')->references(['store_id'])->on('sys_store')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->dropForeign('FK_ORDERS_STATUS');
            $table->dropForeign('FK_ORDERS_STORE');
        });
    }
};
