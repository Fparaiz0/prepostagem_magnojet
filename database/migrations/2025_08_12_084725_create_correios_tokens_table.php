<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('correios_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token', 2048);
            $table->timestamp('valid_until')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('correios_tokens');
    }
};
