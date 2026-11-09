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
        Schema::create('catalog_product', function (Blueprint $table) {
            $table->comment('Tabela de produtos do sistema');
            $table->integer('product_id', true);
            $table->integer('attribute_set_id')->default(0)->index('idx_catalog_attribute_set');
            $table->integer('brand_id')->default(1282)->index('fk_brand_idx');
            $table->integer('status_id')->default(1)->index('idx_product_status');
            $table->string('sku', 50)->index('idx_asin')->comment('Sku unico do produto');
            $table->string('ean')->nullable()->comment('EAN/NBM do produto');
            $table->string('name')->comment('Nome do produto');
            $table->longText('description')->comment('Descrição longa do produto');
            $table->text('short_description')->comment('Descrição curta do produto');
            $table->string('slug_key')->comment('Slug do produto');
            $table->string('image')->nullable()->comment('Imagem padrão do produto');
            $table->string('thumbnail')->nullable()->comment('Imagem padrão reduzida do produto');
            $table->string('video_url')->nullable()->comment('Video URL do Youtube');
            $table->integer('qty')->comment('Quantidade do produto');
            $table->decimal('weight', 12, 4)->comment('Peso do produto');
            $table->decimal('volume_weight', 12, 4)->comment('Peso Cubado do Produto');
            $table->decimal('height', 12, 4)->comment('Altura do produto');
            $table->decimal('width', 12, 4)->comment('Comprimento do produto');
            $table->decimal('length', 12, 4)->comment('Largura do produto');
            $table->boolean('is_excluded')->default(false)->comment('O produto foi excluido do sistema');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();

            $table->fullText(['name', 'description', 'sku'], 'idx_search');
            $table->unique(['sku'], 'sku_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_product');
    }
};
