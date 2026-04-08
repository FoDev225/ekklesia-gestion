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
        Schema::create('believer_departures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('believer_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['quit', 'deceased']);
            $table->string('reason')->nullable();
            $table->text('comment')->nullable();
            $table->date('departure_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('believer_departures');
    }
};
