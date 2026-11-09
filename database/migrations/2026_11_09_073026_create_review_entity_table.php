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
        Schema::create('review_entity', function (Blueprint $table) {
            $table->comment('Entities that can receive reviews');
            $table->smallIncrements('entity_id')->comment('Review entity id');
            $table->string('entity_code', 32)->unique('unq_review_entity_code')->comment('Review entity code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_entity');
    }
};
