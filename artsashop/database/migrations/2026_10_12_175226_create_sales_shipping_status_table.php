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
        Schema::create('sales_shipping_status', function (Blueprint $table) {
            $table->integer('shipping_status_id', true);
            $table->integer('bbexp_status_id')->nullable();
            $table->integer('sales_status_id')->nullable();
            $table->string('descricao_status', 45);
            $table->integer('ordering')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_shipping_status');
    }
};
