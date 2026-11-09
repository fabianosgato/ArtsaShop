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
        Schema::create('eav_attributes', function (Blueprint $table) {
            $table->integer('attribute_id', true);
            $table->string('attribute_code');
            $table->string('attribute_label');
            $table->string('slug_key')->nullable();
            $table->text('note')->nullable();
            $table->boolean('is_system')->default(false);
            $table->boolean('is_global')->nullable()->default(true);
            $table->boolean('is_filterable')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eav_attributes');
    }
};
