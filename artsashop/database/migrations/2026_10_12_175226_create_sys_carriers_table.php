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
        Schema::create('sys_carriers', function (Blueprint $table) {
            $table->comment('Transportadoras do sistema');
            $table->integer('carrier_id', true);
            $table->string('carrier_name');
            $table->integer('multiplier');
            $table->string('pricing_type', 20);
            $table->decimal('weight_cost_kg', 12)->nullable()->default(0);
            $table->decimal('highest_cost_kg', 12)->nullable()->default(0);
            $table->boolean('status')->nullable()->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_carriers');
    }
};
