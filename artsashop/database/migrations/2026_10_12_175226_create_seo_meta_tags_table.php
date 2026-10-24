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
        Schema::create('seo_meta_tags', function (Blueprint $table) {
            $table->increments('seo_meta_tag_id');
            $table->string('name', 50)->nullable();
            $table->string('property', 100)->nullable();
            $table->string('status', 50)->default('active');
            $table->string('group', 50)->nullable();
            $table->string('input_type', 50)->default('text');
            $table->string('default_value')->nullable();
            $table->string('input_placeholder')->nullable();
            $table->string('input_label')->nullable();
            $table->string('input_info')->nullable();
            $table->string('visibility', 50)->default('page');
            $table->tinyInteger('ordernation')->default(50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_meta_tags');
    }
};
