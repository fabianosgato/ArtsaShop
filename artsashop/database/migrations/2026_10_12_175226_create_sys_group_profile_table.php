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
        Schema::create('sys_group_profile', function (Blueprint $table) {
            $table->integer('profile_id', true);
            $table->integer('group_id')->index('idx_profile_group');
            $table->integer('module_menu_id')->index('idx_profile_module_menus');
            $table->boolean('view')->default(true);
            $table->boolean('info')->default(true);
            $table->boolean('altr')->default(true);
            $table->boolean('excl')->default(true);
            $table->boolean('status')->default(true);
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_group_profile');
    }
};
