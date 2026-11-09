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
        Schema::table('sales_orders_tracking', function (Blueprint $table) {
            $table->foreign(['order_id'], 'FK_19D4538E8D9F6D38')->references(['order_id'])->on('sales_orders')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_orders_tracking', function (Blueprint $table) {
            $table->dropForeign('FK_19D4538E8D9F6D38');
        });
    }
};
