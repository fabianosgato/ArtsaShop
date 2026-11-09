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
        Schema::create('sales_order_status', function (Blueprint $table) {
            $table->comment('Tabela que define os status de pedidos');
            $table->integer('status_id', true);
            $table->string('status', 32)->comment('Status de pedidos');
            $table->string('label', 128)->comment('Descrição do Pedido');
            $table->text('color')->nullable()->comment('Cor da linha do pedido');
            $table->boolean('is_enabled')->default(false)->comment('Identifica o pedido como aprovado');
            $table->integer('ordination')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_status');
    }
};
