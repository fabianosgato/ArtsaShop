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
        Schema::create('sys_template_emails', function (Blueprint $table) {
            $table->comment('Email Templates');
            $table->increments('template_id')->comment('Template Id');
            $table->string('template_code', 150)->unique('unq_core_email_template_template_code')->comment('Template Name');
            $table->text('template_text')->comment('Template Content');
            $table->text('template_styles')->nullable()->comment('Templste Styles');
            $table->unsignedInteger('template_type')->nullable()->comment('Template Type');
            $table->string('template_subject', 200)->comment('Template Subject');
            $table->string('template_sender_name', 200)->nullable()->comment('Template Sender Name');
            $table->string('template_sender_email', 200)->nullable()->comment('Template Sender Email');
            $table->timestamp('created')->nullable()->index('idx_core_email_template_added_at')->comment('Date of Template Creation');
            $table->timestamp('modified')->nullable()->index('idx_core_email_template_modified_at')->comment('Date of Template Modification');
            $table->boolean('flg_liberado')->nullable()->default(true)->comment('Status de liberacao');
            $table->boolean('flg_excluido')->nullable()->default(true)->comment('Status de exclusao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_template_emails');
    }
};
