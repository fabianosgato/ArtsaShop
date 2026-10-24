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
        Schema::create('sales_orders_tracking', function (Blueprint $table) {
            $table->integer('tracking_id', true);
            $table->integer('order_id')->index('idx_19d4538e8d9f6d38');
            $table->string('tracking_code');
            $table->string('carrier');
            $table->string('method');
            $table->string('url');
            $table->timestamp('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders_tracking');
    }
};
