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
        Schema::create('sales_order_address', function (Blueprint $table) {
            $table->integer('entity_id', true);
            $table->integer('order_id')->index('fk_order_address_idx');
            $table->integer('customer_id')->index('fk_customer_address_idx');
            $table->string('customer_name');
            $table->string('customer_phone', 45);
            $table->string('customer_cellphone', 45);
            $table->string('postcode', 45);
            $table->string('street');
            $table->string('number', 45)->nullable();
            $table->string('region')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood', 145);
            $table->string('country', 45)->nullable();
            $table->string('city', 145)->nullable();
            $table->text('detail')->nullable();
            $table->text('reference')->nullable();
            $table->string('address_type', 45)->default('billing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_address');
    }
};
