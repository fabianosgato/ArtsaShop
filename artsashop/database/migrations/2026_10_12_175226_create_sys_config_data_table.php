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
        Schema::create('sys_config_data', function (Blueprint $table) {
            $table->increments('config_id')->comment('Config Id');
            $table->string('label');
            $table->string('path')->default('general')->unique('unq_config_data_id_path')->comment('Config Path');
            $table->text('value')->nullable()->comment('Config Value');
            $table->string('note')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_config_data');
    }
};
