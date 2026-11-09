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
        Schema::table('sys_group_profile', function (Blueprint $table) {
            $table->foreign(['group_id'], 'FK_PROFILE_GROUP')->references(['group_id'])->on('sys_group')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['module_menu_id'], 'FK_PROFILE_MODULE_MENUS')->references(['module_menu_id'])->on('sys_modules_menus')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sys_group_profile', function (Blueprint $table) {
            $table->dropForeign('FK_PROFILE_GROUP');
            $table->dropForeign('FK_PROFILE_MODULE_MENUS');
        });
    }
};
