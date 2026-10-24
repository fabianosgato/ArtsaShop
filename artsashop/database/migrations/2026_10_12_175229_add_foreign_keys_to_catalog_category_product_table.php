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
        Schema::table('catalog_category_product', function (Blueprint $table) {
            $table->foreign(['category_id'], 'FK_CAT_CTGR_PRD_CTGR_ID_CAT_CTGR_ENTT_ENTT_ID')->references(['entity_id'])->on('catalog_category_entity')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['product_id'], 'FK_CAT_CTGR_PRD_PRD_ID_CAT_PRD_ENTT_ENTT_ID')->references(['product_id'])->on('catalog_product')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catalog_category_product', function (Blueprint $table) {
            $table->dropForeign('FK_CAT_CTGR_PRD_CTGR_ID_CAT_CTGR_ENTT_ENTT_ID');
            $table->dropForeign('FK_CAT_CTGR_PRD_PRD_ID_CAT_PRD_ENTT_ENTT_ID');
        });
    }
};
