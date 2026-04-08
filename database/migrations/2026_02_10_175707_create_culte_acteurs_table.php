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
        Schema::create('culte_acteurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('culte_id')->constrained()->cascadeOnDelete();
            $table->foreignId('believer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('culte_role_id')->constrained()->cascadeOnDelete();

            $table->enum('statut', ['titulaire', 'suppleant'])->default('titulaire');

            $table->timestamps();

            $table->unique(
                ['culte_id', 'believer_id', 'culte_role_id', 'statut'],
                'culte_acteur_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('culte_acteurs');
    }
};
