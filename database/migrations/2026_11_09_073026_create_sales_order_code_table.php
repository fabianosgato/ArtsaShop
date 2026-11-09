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
        Schema::create('sales_order_code', function (Blueprint $table) {
            $table->comment('Codigo ID dos pedidos aprovados');
            $table->integer('entity_id', true);
            $table->integer('order_id')->index('idx_sales_order_code')->comment('ID do pedido no sistema');
            $table->string('increment_code', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_code');
    }
};
