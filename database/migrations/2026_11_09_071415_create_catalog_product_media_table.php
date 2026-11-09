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
        Schema::create('catalog_product_media', function (Blueprint $table) {
            $table->comment('Product media files');
            $table->integer('media_id', true);
            $table->integer('product_id')->index('idx_catalog_product_image');
            $table->string('media_type', 20)->default('image/jpeg');
            $table->string('media_file');
            $table->string('media_url');
            $table->smallInteger('sort_order')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog_product_media');
    }
};
