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
        Schema::create('sys_modules_menus', function (Blueprint $table) {
            $table->integer('module_menu_id', true);
            $table->integer('module_id')->index('idx_module_menus');
            $table->string('menu_name', 150);
            $table->string('access_type', 150)->comment('Tipo de acesso que será utilizado nas validações de grupos para permitir o acesso');
            $table->string('menu_link')->nullable();
            $table->integer('menu_order')->default(0);
            $table->boolean('is_visible')->comment('Valida se este menu será visível em todo o sistema');
            $table->boolean('status')->default(false);
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_modules_menus');
    }
};
