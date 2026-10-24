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
        Schema::create('sales_order_history', function (Blueprint $table) {
            $table->comment('Sales Order History');
            $table->integer('history_id', true);
            $table->integer('order_id')->index('idx_history_order')->comment('ID do pedido');
            $table->boolean('is_customer_notified')->nullable()->comment('Cliente Deve ser Avisado');
            $table->unsignedTinyInteger('is_visible_on_front')->default(0)->comment('Visivel para o cliente');
            $table->text('comment')->nullable()->comment('Comment');
            $table->string('status_code', 45)->nullable()->comment('Status do pedido');
            $table->timestamp('created_at')->nullable()->useCurrent()->comment('Created At');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_history');
    }
};
