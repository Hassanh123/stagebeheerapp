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

    // Verwijst naar companies (niet 'bedrijven')
    $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');

    // Verwijst naar teachers
    $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');

    $table->timestamps();
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
