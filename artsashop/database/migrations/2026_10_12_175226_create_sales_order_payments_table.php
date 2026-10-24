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
        Schema::create('sales_order_payments', function (Blueprint $table) {
            $table->integer('entity_id', true);
            $table->integer('order_id')->index('fk_order_payment_idx');
            $table->string('method', 145)->nullable();
            $table->text('description')->nullable();
            $table->decimal('value', 12)->nullable();
            $table->longText('additional_information');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_payments');
    }
};
