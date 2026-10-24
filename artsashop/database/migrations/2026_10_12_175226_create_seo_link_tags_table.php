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
        Schema::create('seo_link_tags', function (Blueprint $table) {
            $table->increments('seo_link_tag_id');
            $table->unsignedInteger('seo_page_id')->nullable()->index('idx_seo_link_tags_page');
            $table->string('rel', 100)->nullable();
            $table->string('href')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_link_tags');
    }
};
