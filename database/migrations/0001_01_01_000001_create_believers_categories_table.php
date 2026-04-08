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
        Schema::create('believers_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Exemple : Nourrisson
            $table->integer('min_age'); // Âge minimum en mois
            $table->integer('max_age')->nullable(); // Âge maximum en mois
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('believers_categories');
    }
};
