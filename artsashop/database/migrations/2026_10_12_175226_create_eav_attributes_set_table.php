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
        Schema::create('eav_attributes_set', function (Blueprint $table) {
            $table->comment('Catalog AttributeSet Table');
            $table->integer('attribute_set_id', true)->comment('ID do Grupo de Atributo');
            $table->string('attribute_set_key', 45);
            $table->string('attribute_set_name');
            $table->text('stemming_words')->nullable();
            $table->integer('product_qty')->default(0);
            $table->integer('product_qty_stock')->default(0);
            $table->integer('product_qty_disable')->default(0);
            $table->integer('product_qty_excluded')->default(0);
            $table->boolean('is_default')->default(false);
            $table->boolean('is_category')->nullable()->default(false);
            $table->boolean('status')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eav_attributes_set');
    }
};
