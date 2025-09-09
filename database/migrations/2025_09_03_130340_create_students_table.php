<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id(); // auto-increment primary key
            $table->string('naam');
            $table->string('email')->unique();
            $table->string('student_number')->unique();
            $table->foreignId('stage_id')->nullable()->constrained('stages')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
