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
        Schema::create('believers', function (Blueprint $table) {
            $table->id();
            $table->string('register_number', 14)->unique()->nullable();
            $table->string('lastname');
            $table->string('firstname');
            $table->enum('gender', ['Féminin', 'Masculin']);

            $table->enum('marital_status', ['Célibataire', 'Marié(e)', 'Divorcé(e)', 'Veuf(ve)'])->nullable();
            $table->date('marriage_date')->nullable();
            $table->string('spouse_name', 100)->nullable();

            $table->date('birth_date');
            $table->string('birth_place');
            $table->string('ethnicity');
            $table->string('nationality');
            $table->integer('number_of_children')->default(0);

            $table->string('cni_number', 14)->unique()->nullable();

            $table->foreignId('category_id')->nullable()->constrained('believers_categories')->nullOnDelete();
            $table->foreignId('family_id')->nullable()->constrained('families')->nullOnDelete();

            $table->boolean('is_active')->default(true);
            $table->date('left_at')->nullable();
            $table->date('deceased_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('believers');
    }
};
