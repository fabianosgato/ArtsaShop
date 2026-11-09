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
        Schema::table('sys_users', function (Blueprint $table) {
            $table->foreign(['group_id'], 'FK_USER_GROUP')->references(['group_id'])->on('sys_group')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sys_users', function (Blueprint $table) {
            $table->dropForeign('FK_USER_GROUP');
        });
    }
};
