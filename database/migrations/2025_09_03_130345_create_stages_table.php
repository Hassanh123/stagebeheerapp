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
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->string('titel');
            $table->text('beschrijving');
            $table->string('status')->default('vrij');
            $table->foreignId('bedrijf_id')->constrained('bedrijven');
            $table->foreignId('teacher_id')->constrained('teachers');
            $table->timestamps(); // created_at en updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};
