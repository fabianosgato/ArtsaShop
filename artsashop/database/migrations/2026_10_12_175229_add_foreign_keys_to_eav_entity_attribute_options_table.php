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
        Schema::table('eav_entity_attribute_options', function (Blueprint $table) {
            $table->foreign(['entity_attribute_id'], 'FK_ATTRIBUTES_ENTITIES_VALUES')->references(['entity_attribute_id'])->on('eav_entity_attribute')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['attribute_id'], 'FK_EAV_ATTRIBUTE_OPTIONS')->references(['attribute_id'])->on('eav_attributes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['attribute_set_id'], 'FK_ENTITY_OPTIONS_ATTRIBUTE_SET')->references(['attribute_set_id'])->on('eav_attributes_set')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eav_entity_attribute_options', function (Blueprint $table) {
            $table->dropForeign('FK_ATTRIBUTES_ENTITIES_VALUES');
            $table->dropForeign('FK_EAV_ATTRIBUTE_OPTIONS');
            $table->dropForeign('FK_ENTITY_OPTIONS_ATTRIBUTE_SET');
        });
    }
};
