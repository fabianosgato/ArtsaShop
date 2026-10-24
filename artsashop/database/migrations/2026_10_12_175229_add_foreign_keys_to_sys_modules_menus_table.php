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
        Schema::table('sys_modules_menus', function (Blueprint $table) {
            $table->foreign(['module_id'], 'FK_MODULE_MENUS')->references(['module_id'])->on('sys_modules')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sys_modules_menus', function (Blueprint $table) {
            $table->dropForeign('FK_MODULE_MENUS');
        });
    }
};
