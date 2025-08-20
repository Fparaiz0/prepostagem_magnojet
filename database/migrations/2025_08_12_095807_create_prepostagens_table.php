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
        Schema::create('prepostagens', function (Blueprint $table) {
            $table->id();
            $table->string('name_sender');
            $table->string('cnpj_sender')->nullable();
            $table->string('cep_sender');
            $table->string('public_place_sender');
            $table->string('number_sender');
            $table->string('neighborhood_sender')->nullable();
            $table->string('city_sender');
            $table->string('uf_sender');
            $table->string('name_recipient');
            $table->string('cnpj_recipient')->nullable();
            $table->string('cep_recipient');
            $table->string('public_place_recipient');
            $table->string('number_recipient');
            $table->string('complement_recipient')->nullable(); 
            $table->string('neighborhood_recipient')->nullable();
            $table->string('city_recipient');
            $table->string('uf_recipient');
            $table->string('code_service');
            $table->string('object_code');
            $table->string('invoice_number');
            $table->string('nfe_key');
            $table->string('weight_informed');
            $table->string('code_format_informed_object');
            $table->string('height_informed');
            $table->string('width_informed');
            $table->string('length_informed');
            $table->string('diameter_informed');
            $table->string('aware_object_not_forbidden');
            $table->string('payment_method');
            $table->string('observation')->nullable();
            $table->integer('situation')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prepostagens');
    }
};
