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
        Schema::table('sales_order_quote_item', function (Blueprint $table) {
            $table->foreign(['quote_id'], 'fk_quote_item_quote')->references(['quote_id'])->on('sales_order_quote')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_order_quote_item', function (Blueprint $table) {
            $table->dropForeign('fk_quote_item_quote');
        });
    }
};
