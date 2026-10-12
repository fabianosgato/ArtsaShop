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
        Schema::table('eav_entity_attribute', function (Blueprint $table) {
            $table->foreign(['attribute_id'], 'FK_ATTRIBUTE')->references(['attribute_id'])->on('eav_attributes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['attribute_set_id'], 'FK_ATTRIBUTESET')->references(['attribute_set_id'])->on('eav_attributes_set')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eav_entity_attribute', function (Blueprint $table) {
            $table->dropForeign('FK_ATTRIBUTE');
            $table->dropForeign('FK_ATTRIBUTESET');
        });
    }
};
