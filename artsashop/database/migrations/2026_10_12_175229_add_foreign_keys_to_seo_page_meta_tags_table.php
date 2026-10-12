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
        Schema::table('seo_page_meta_tags', function (Blueprint $table) {
            $table->foreign(['seo_meta_tag_id'], 'FK_SEO_PAGE_META_TAGS_SEO_META_TAG')->references(['seo_meta_tag_id'])->on('seo_meta_tags')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['seo_page_id'], 'FK_SEO_PAGE_META_TAGS_SEO_PAGE')->references(['seo_page_id'])->on('seo_pages')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_page_meta_tags', function (Blueprint $table) {
            $table->dropForeign('FK_SEO_PAGE_META_TAGS_SEO_META_TAG');
            $table->dropForeign('FK_SEO_PAGE_META_TAGS_SEO_PAGE');
        });
    }
};
