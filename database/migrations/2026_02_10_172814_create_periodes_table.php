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
        Schema::create('periodes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom de la période (ex: "Octobre 2024- Février 2025")
            $table->text('general_theme')->nullable(); // Thème général de la période
            $table->date('start_date'); // Date de début de la période
            $table->date('end_date'); // Date de fin de la période
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodes');
    }
};
