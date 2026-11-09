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
        Schema::create('site_blocks_featured', function (Blueprint $table) {
            $table->comment('Blocos de destaque da home do site');
            $table->integer('featured_block_id', true);
            $table->string('featured_block_title', 150);
            $table->integer('number_products');
            $table->integer('short_order');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_blocks_featured');
    }
};
