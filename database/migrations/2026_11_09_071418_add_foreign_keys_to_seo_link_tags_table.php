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
        Schema::table('seo_link_tags', function (Blueprint $table) {
            $table->foreign(['seo_page_id'], 'FK_SEO_LINK_TAGS_PAGE')->references(['seo_page_id'])->on('seo_pages')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_link_tags', function (Blueprint $table) {
            $table->dropForeign('FK_SEO_LINK_TAGS_PAGE');
        });
    }
};
