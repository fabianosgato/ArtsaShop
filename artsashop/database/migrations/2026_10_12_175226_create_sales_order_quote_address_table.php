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
        Schema::create('sales_order_quote_address', function (Blueprint $table) {
            $table->comment('Sales Quote Address');
            $table->integer('address_id', true)->comment('Address Id');
            $table->integer('quote_id')->default(0)->index('idx_order_quote_address_quote_id')->comment('Quote Id');
            $table->string('address_type')->nullable()->comment('Tipo do endereço');
            $table->string('street')->nullable()->comment('Endereço');
            $table->string('neighborhood')->nullable()->comment('Bairro');
            $table->string('complement')->nullable()->comment('Complemento');
            $table->string('number')->nullable()->comment('Numero residencial');
            $table->string('city')->nullable()->comment('Cidade');
            $table->string('region')->nullable()->comment('Estado');
            $table->string('postcode')->nullable()->comment('Cep');
            $table->string('cellphone')->nullable()->comment('Celular');
            $table->string('telephone', 20)->nullable();
            $table->string('recipient_name')->nullable();
            $table->smallInteger('save_in_address_book')->nullable()->default(0)->comment('Save In Address Book');
            $table->timestamp('created_at')->useCurrent()->comment('Created At');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent()->comment('Updated At');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_quote_address');
    }
};
