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
        Schema::create('cms_block', function (Blueprint $table) {
            $table->comment('CMS Block Table');
            $table->smallInteger('block_id', true)->comment('Block ID');
            $table->string('title')->comment('Block Title');
            $table->string('identifier')->comment('Block String Identifier');
            $table->mediumText('content')->nullable()->comment('Block Content');
            $table->smallInteger('is_active')->default(1)->comment('Is Block Active');
            $table->timestamp('created_at')->nullable()->useCurrent()->comment('Block Creation Time');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent()->comment('Block Modification Time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_block');
    }
};
