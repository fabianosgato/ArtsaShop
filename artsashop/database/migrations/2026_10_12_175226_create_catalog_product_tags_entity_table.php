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
        Schema::create('catalog_product_tags_entity', function (Blueprint $table) {
            $table->comment('Relação com as tags com produtos');
            $table->integer('entity_id', true);
            $table->integer('tag_id')->index('idx_product_tag');
            $table->integer('product_id')->index('idx_tag_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_product_tags_entity');
    }
};
