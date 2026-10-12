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
        Schema::create('sys_url_rewrite', function (Blueprint $table) {
            $table->comment('Url Rewrites');
            $table->increments('url_rewrite_id')->comment('Rewrite Id');
            $table->string('request_path')->nullable()->unique('unq_core_url_rewrite_request_path')->comment('Request Path');
            $table->string('target_path')->nullable()->comment('Target Path');
            $table->unsignedSmallInteger('is_system')->nullable()->default(1)->comment('Defines is Rewrite System');
            $table->string('target_type')->nullable()->comment('Target type');
            $table->string('options')->nullable()->comment('Options');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();

            $table->index(['target_path', 'request_path'], 'idx_core_url_rewrite_target_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_url_rewrite');
    }
};
