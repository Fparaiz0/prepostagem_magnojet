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
        Schema::create('correios_etiquetas', function (Blueprint $table) {
            $table->id();
            $table->string('object_code')->unique();
            $table->integer('used');
            $table->string('invoice')->nullable()->default(null);
            $table->integer('selected')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correios_etiquetas');
    }
};