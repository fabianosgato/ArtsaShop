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
            // Drop the existing FK with SET NULL
            $table->dropForeign('FK_SEO_PAGE_META_TAGS_SEO_PAGE');
            
            // Add new FK with CASCADE
            $table->foreign(['seo_page_id'], 'FK_SEO_PAGE_META_TAGS_SEO_PAGE')
                ->references(['seo_page_id'])->on('seo_pages')
                ->onUpdate('no action')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_page_meta_tags', function (Blueprint $table) {
            // Drop the CASCADE FK
            $table->dropForeign('FK_SEO_PAGE_META_TAGS_SEO_PAGE');
            
            // Restore original FK with SET NULL
            $table->foreign(['seo_page_id'], 'FK_SEO_PAGE_META_TAGS_SEO_PAGE')
                ->references(['seo_page_id'])->on('seo_pages')
                ->onUpdate('no action')
                ->onDelete('set null');
        });
    }
};
