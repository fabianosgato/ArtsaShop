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
        Schema::create('sys_store', function (Blueprint $table) {
            $table->comment('Websites Stores');
            $table->increments('store_id')->comment('Store Id');
            $table->string('code', 32)->unique('unq_core_website_code')->comment('Código unico da loja');
            $table->integer('parent_id')->nullable()->default(0);
            $table->string('code_order', 20);
            $table->string('host')->comment('URL da loja');
            $table->string('store_name')->comment('Nome da Loja');
            $table->string('layout', 125)->comment('Layout da Loja');
            $table->string('type', 64)->nullable()->default('default')->comment('Website type');
            $table->boolean('is_default')->nullable()->default(false)->comment('Define se a loja é padrão');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_store');
    }
};
