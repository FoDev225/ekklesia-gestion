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
        Schema::create('cultes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->nullable()->constrained()->nullOnDelete();
            $table->date('culte_date');
            $table->string('culte_theme');
            $table->string('biblical_text')->nullable();
            $table->enum('culte_type', ['Commun', 'Spécial', 'Sénoufo', 'Français'])->default('Commun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cultes');
    }
};
