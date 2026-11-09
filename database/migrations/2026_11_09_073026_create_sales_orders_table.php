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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->integer('order_id', true);
            $table->unsignedInteger('store_id')->index('idx_orders_store')->comment('Id a loja');
            $table->integer('status_id')->nullable()->default(1)->index('idx_orders_status')->comment('Id do status do pedido');
            $table->string('increment_id', 145)->nullable()->comment('Id incremental do Pedido');
            $table->string('store_code')->comment('Código da loja');
            $table->string('status_type')->comment('Tipo do status');
            $table->string('status_label')->comment('Descrição do status');
            $table->string('status_code')->comment('Código do status');
            $table->string('payment_method', 20)->comment('Tipo do Pagamento');
            $table->string('payment_description')->comment('Descrição do pagamento');
            $table->decimal('base_discount_amount', 12)->comment('Valor do desconto do pedido');
            $table->decimal('base_subtotal', 12)->comment('Subtotal do pedido');
            $table->decimal('base_grand_total', 12)->comment('Total do pedido');
            $table->string('canal')->comment('Canal de onde vem o pedido');
            $table->string('remote_ip', 45)->comment('IP do cliente');
            $table->timestamp('estimated_delivery_date')->nullable()->comment('Data de Entrega Estimada do Pedido');
            $table->timestamp('approved_date')->nullable()->comment('Data de aprovação do pedido');
            $table->timestamp('delivered_date')->nullable()->comment('Data de Entrega do pedido');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->decimal('base_shipping_amount', 12);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
