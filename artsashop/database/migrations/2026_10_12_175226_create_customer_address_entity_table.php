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
        Schema::create('customer_address_entity', function (Blueprint $table) {
            $table->integer('address_id', true);
            $table->integer('customer_id')->index('idx_customer');
            $table->enum('address_type', ['billing', 'shipping', 'both'])->default('both');
            $table->string('recipient_name');
            $table->string('postcode', 20);
            $table->string('street');
            $table->string('number', 45)->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood');
            $table->string('city');
            $table->string('region', 45);
            $table->string('country', 100)->default('Brasil');
            $table->string('phone', 45)->nullable();
            $table->string('cellphone', 45)->nullable();
            $table->boolean('is_default_billing')->default(false);
            $table->boolean('is_default_shipping')->default(false);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();

            $table->index(['customer_id', 'is_default_billing'], 'idx_default_billing');
            $table->index(['customer_id', 'is_default_shipping'], 'idx_default_shipping');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_address_entity');
    }
};
