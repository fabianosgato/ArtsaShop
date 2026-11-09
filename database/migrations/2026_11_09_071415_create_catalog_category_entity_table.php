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
        Schema::create('catalog_category_entity', function (Blueprint $table) {
            $table->comment('Catalog Category Table');
            $table->integer('entity_id', true)->comment('Entity ID');
            $table->integer('parent_id')->default(0)->comment('Parent Category ID');
            $table->string('category')->comment('Category Name');
            $table->string('slug_key')->comment('Url key');
            $table->integer('level')->default(0)->index('catalog_category_entity_level')->comment('Tree Level');
            $table->string('category_path')->comment('Path da Categoria Único');
            $table->boolean('has_products')->default(false);
            $table->timestamp('created_at')->useCurrent()->comment('Creation Time');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent()->comment('Update Time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_category_entity');
    }
};
