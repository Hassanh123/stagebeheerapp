<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // koppeling naar users
            $table->string('naam');
            $table->string('email')->unique();
            $table->string('student_number')->unique();
            $table->string('photo_url')->nullable();
            $table->foreignId('stage_id')->nullable()->constrained('stages'); // link chosen stage
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
