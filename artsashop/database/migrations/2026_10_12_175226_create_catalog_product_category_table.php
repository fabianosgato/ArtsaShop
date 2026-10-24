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
        Schema::create('catalog_product_category', function (Blueprint $table) {
            $table->comment('Categoria final do produto');
            $table->integer('entity_id', true);
            $table->integer('product_id')->index('idx_product_category_final');
            $table->string('category_name')->comment('Nome da Categoria');
            $table->string('slug_key')->comment('URL da Categoria');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_product_category');
    }
};
