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
        Schema::create('cms_page', function (Blueprint $table) {
            $table->integer('page_id', true)->comment('Page ID');
            $table->string('title')->comment('Page Title');
            $table->text('seo_meta_description')->nullable()->comment('Page Meta Description');
            $table->string('seo_page_title')->comment('Page Content Heading');
            $table->longText('content')->nullable()->comment('Page Content');
            $table->string('slug_key', 100)->index('idx_cms_page_identifier')->comment('Page String Identifier');
            $table->boolean('is_active')->default(true)->comment('Is Page Active');
            $table->timestamp('created_at')->nullable()->useCurrent()->comment('Page Creation Date');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent()->comment('Page Modification Date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_page');
    }
};
