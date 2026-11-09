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
        Schema::table('sales_order_customer', function (Blueprint $table) {
            $table->foreign(['customer_id'], 'FK_ENTITY_CUSTOMER')->references(['customer_id'])->on('customer_entity')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['order_id'], 'FK_ENTITY_ORDER')->references(['order_id'])->on('sales_orders')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_order_customer', function (Blueprint $table) {
            $table->dropForeign('FK_ENTITY_CUSTOMER');
            $table->dropForeign('FK_ENTITY_ORDER');
        });
    }
};
