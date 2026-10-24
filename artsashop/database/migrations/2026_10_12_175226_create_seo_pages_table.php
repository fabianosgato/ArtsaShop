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
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->increments('seo_page_id');
            $table->string('path')->unique();
            $table->string('object', 80)->nullable()->index();
            $table->string('object_id', 80)->nullable()->index();
            $table->string('robot_index', 50)->nullable()->default('noindex');
            $table->string('robot_follow', 50)->nullable()->default('nofollow');
            $table->string('canonical_url')->nullable();
            $table->string('title', 100)->nullable()->index();
            $table->string('title_source', 100)->nullable()->index();
            $table->string('description', 180)->nullable();
            $table->string('description_source', 180)->nullable();
            $table->string('change_frequency', 20)->default('monthly');
            $table->double('priority')->default(0.5);
            $table->longText('schema')->nullable();
            $table->string('focus_keyword')->nullable();
            $table->text('tags')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_pages');
    }
};
