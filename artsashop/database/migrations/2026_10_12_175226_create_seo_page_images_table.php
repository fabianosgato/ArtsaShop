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
        Schema::create('seo_page_images', function (Blueprint $table) {
            $table->increments('seo_page_image_id');
            $table->unsignedInteger('seo_page_id')->index('idx_seo_page_images_page');
            $table->string('src')->nullable()->index('idx_seo_page_images_src');
            $table->string('title', 100)->nullable();
            $table->string('caption', 100)->nullable();
            $table->string('location', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_page_images');
    }
};
