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
        Schema::create('sys_rastreio_historico', function (Blueprint $table) {
            $table->integer('historico_pk', true);
            $table->integer('rastreio_fk');
            $table->integer('pedido_fk');
            $table->integer('status_fk');
            $table->string('correios_id', 45)->nullable();
            $table->string('correios_status')->nullable();
            $table->dateTime('created');
            $table->dateTime('updated');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_rastreio_historico');
    }
};
