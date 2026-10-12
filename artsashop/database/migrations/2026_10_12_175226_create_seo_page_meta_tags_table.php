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
        Schema::create('seo_page_meta_tags', function (Blueprint $table) {
            $table->increments('seo_page_meta_tag_id');
            $table->unsignedInteger('seo_page_id')->nullable()->index('idx_seo_page_meta_tags_seo_page');
            $table->unsignedInteger('seo_meta_tag_id')->index('idx_seo_page_meta_tags_seo_meta_tag');
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_page_meta_tags');
    }
};
