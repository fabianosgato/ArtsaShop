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
        Schema::create('catalog_product_attributes', function (Blueprint $table) {
            $table->integer('relacional_id', true);
            $table->integer('attribute_set_id')->index('idx_attributeset_attribute_values');
            $table->integer('attribute_id')->index('idx_747a21d5b6e62efa');
            $table->integer('product_id')->index('idx_747a21d54584665a');
            $table->string('attribute_code');
            $table->string('value')->nullable();
            $table->string('serialized_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_product_attributes');
    }
};
