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
        Schema::create('sales_discount_rule', function (Blueprint $table) {
            $table->integer('rule_id', true);
            $table->enum('rule_type', ['coupon', 'payment'])->default('coupon')->comment('Tipo de desconto a ser aplicado');
            $table->string('code', 100)->comment('Identificador da regra');
            $table->string('label')->comment('Descrição da regra');
            $table->enum('apply_to', ['cart', 'product'])->default('cart')->comment('Onde o desconto será aplicado');
            $table->enum('discount_type', ['percent', 'fixed'])->comment('Tipo do calculo do desconto');
            $table->decimal('discount_value', 12)->nullable()->comment('Valor que será descontado no valor final do desconto');
            $table->string('payment_method', 145)->nullable()->index('idx_payment')->comment('pix, credit_card, etc');
            $table->decimal('min_subtotal', 12, 4)->nullable()->comment('Valor minimo do desconto a ser aplicado');
            $table->decimal('max_subtotal', 12, 4)->nullable()->comment('Valor máximo do desconto a ser aplicado');
            $table->integer('max_usage')->default(0)->comment('Máximo de usos por cupom');
            $table->dateTime('starts_at')->nullable()->comment('Data de inico da promoção');
            $table->dateTime('ends_at')->nullable()->comment('Data final da promoção');
            $table->integer('priority')->default(0)->index('idx_priority')->comment('Prioridade do desconto');
            $table->boolean('is_active')->default(true)->index('idx_active')->comment('Estatus do desconto');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_discount_rule');
    }
};
