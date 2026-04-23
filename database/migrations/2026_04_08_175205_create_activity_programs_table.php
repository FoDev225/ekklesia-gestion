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
        Schema::create('activity_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');

            $table->string('title');
            $table->text('theme')->nullable();
            $table->string('moderator')->nullable();
            $table->string('preacher')->nullable();

            $table->date('scheduled_date');
            $table->string('month')->nullable();
            $table->string('year')->nullable();

            $table->string('location')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'canceled'])->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_programs');
    }
};
