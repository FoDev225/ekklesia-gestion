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
        Schema::create('adresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('believer_id')->nullable()->constrained('believers')->nullOnDelete();
            $table->string('whatsapp_number', 10)->nullable();
            $table->string('phone_number', 10)->nullable();
            $table->string('email')->nullable();
            $table->string('commune')->nullable();
            $table->string('quartier')->nullable();
            $table->string('sous_quartier')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adresses');
    }
};
