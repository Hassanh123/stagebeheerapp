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
    $table->enum('status', ['vrij', 'gekozen', 'akkoord', 'niet_akkoord'])->default('vrij');
    $table->foreignId('company_id')->constrained('companies'); // <- correct
    $table->foreignId('teacher_id')->constrained('teachers');
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
