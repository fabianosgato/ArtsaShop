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
        Schema::create('customer_entity', function (Blueprint $table) {
            $table->integer('customer_id', true);
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('vat_number', 145)->nullable();
            $table->string('date_of_birth', 45)->nullable();
            $table->string('customer_passwd')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_entity');
    }
};
