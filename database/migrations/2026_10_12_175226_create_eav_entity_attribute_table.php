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
        Schema::create('eav_entity_attribute', function (Blueprint $table) {
            $table->comment('Eav Entity Attributes');
            $table->integer('entity_attribute_id', true)->comment('Entity Attribute Id');
            $table->integer('attribute_set_id')->default(0)->index('fk_attributeset_id_idx')->comment('Attribute Set Id');
            $table->integer('attribute_id')->default(0)->index('fk_attribute_id_idx')->comment('Attribute Id');
            $table->string('frontend_input')->nullable()->default('text');
            $table->smallInteger('sort_order')->default(0)->comment('Sort Order');
            $table->boolean('is_visible')->nullable()->default(false);
            $table->boolean('is_searchable')->nullable()->default(false);
            $table->boolean('is_required');
            $table->longText('default_value')->nullable();
            $table->longText('values')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();

            $table->index(['attribute_id'], 'fk_attribute_idx');
            $table->index(['attribute_set_id'], 'fk_attributeset_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eav_entity_attribute');
    }
};
