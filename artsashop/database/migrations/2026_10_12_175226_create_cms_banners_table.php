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
        Schema::create('cms_banners', function (Blueprint $table) {
            $table->increments('banner_id');
            $table->string('store_id')->nullable();
            $table->string('banner_type', 40);
            $table->string('banner_local', 40);
            $table->string('image')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('title')->default('');
            $table->text('content')->nullable();
            $table->string('banner_url')->nullable();
            $table->integer('banner_order')->nullable()->default(0);
            $table->smallInteger('is_active')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_banners');
    }
};
