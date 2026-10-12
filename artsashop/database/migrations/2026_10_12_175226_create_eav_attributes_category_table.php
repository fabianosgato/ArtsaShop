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
        Schema::create('eav_attributes_category', function (Blueprint $table) {
            $table->integer('eav_attribute_set_id')->index('idx_attributeset_id');
            $table->integer('eav_category_products_id')->index('idx_category_id');

            $table->primary(['eav_attribute_set_id', 'eav_category_products_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eav_attributes_category');
    }
};
