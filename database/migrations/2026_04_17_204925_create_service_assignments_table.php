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
        Schema::create('service_assignments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('believer_id')->constrained()->onDelete('cascade')->nullable();
            $table->foreignId('service_id')->constrained()->onDelete('cascade')->nullable();
            $table->foreignId('service_role_id')->constrained()->onDelete('cascade')->nullable();
            $table->foreignId('group_id')->constrained()->onDelete('cascade')->nullable();

            $table->boolean('is_backup')->default(false);
            $table->unique(['service_id', 'service_role_id', 'believer_id'], 'unique_assignment_person');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_assignments');
    }
};
