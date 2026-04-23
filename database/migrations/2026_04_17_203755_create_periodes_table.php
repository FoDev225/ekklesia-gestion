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

            $table->string('name'); // Mars - Juillet 2026
            $table->string('general_theme')->nullable(); // Thème général de la période

            $table->date('start_date'); // Date de début de la période
            $table->date('end_date'); // Date de fin de la période

            $table->boolean('is_active')->default(true); // Indique si la période est active
            $table->boolean('is_archived')->default(false); // Historique
            
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
