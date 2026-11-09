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
        Schema::create('eav_entity_attribute_options', function (Blueprint $table) {
            $table->comment('Valores para atributos');
            $table->integer('eav_attribute_option_id', true);
            $table->integer('attribute_set_id')->index('idx_entity_options_attribute_set');
            $table->integer('attribute_id')->index('idx_eav_attribute_options');
            $table->integer('entity_attribute_id')->index('idx_attributes_entities_values');
            $table->string('option_name');
            $table->string('option_value', 45);
            $table->smallInteger('sort_order');
            $table->boolean('is_default')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eav_entity_attribute_options');
    }
};
