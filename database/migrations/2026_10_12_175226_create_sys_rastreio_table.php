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
        Schema::create('sys_rastreio', function (Blueprint $table) {
            $table->integer('rastreio_pk', true);
            $table->integer('pedido_fk');
            $table->integer('item_fk');
            $table->integer('status_fk');
            $table->integer('empresa_fk');
            $table->string('codigo', 45);
            $table->string('amazon_track', 125)->nullable();
            $table->string('amazon_code', 125)->nullable();
            $table->string('correios_track', 45)->nullable();
            $table->string('hawb_track', 45)->nullable();
            $table->date('delivery_date')->nullable();
            $table->boolean('flg_liberado')->nullable()->default(true);
            $table->boolean('flg_excluido')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_rastreio');
    }
};
