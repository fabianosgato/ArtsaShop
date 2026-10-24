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
        Schema::table('customer_address_entity', function (Blueprint $table) {
            $table->foreign(['customer_id'], 'fk_customer_address_customer')->references(['customer_id'])->on('customer_entity')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_address_entity', function (Blueprint $table) {
            $table->dropForeign('fk_customer_address_customer');
        });
    }
};
