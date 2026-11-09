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
        Schema::create('sys_logs', function (Blueprint $table) {
            $table->integer('entity_id', true);
            $table->string('module')->nullable();
            $table->string('type', 45)->nullable()->default('SYSTEM');
            $table->longText('log')->nullable();
            $table->dateTime('created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_logs');
    }
};
