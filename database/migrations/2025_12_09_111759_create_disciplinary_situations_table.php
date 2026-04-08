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
        Schema::create('disciplinary_situations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('believer_id')->constrained()->onDelete('cascade');
            $table->string('reason');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('observations')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplinary_situations');
    }
};
