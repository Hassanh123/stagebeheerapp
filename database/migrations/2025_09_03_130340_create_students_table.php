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
<<<<<<< HEAD
      Schema::create('students', function (Blueprint $table) {
   $table->id(); // Makes student_id auto-increment primary key
    $table->string('naam');
    $table->string('email')->unique();
    $table->string('student_number')->unique();
    $table->timestamps();
});

=======
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('naam');
            $table->string('email')->unique();
            $table->foreignId('stage_id')->constrained('stages');
            $table->timestamps();
        });
>>>>>>> fb3659679fb7b861ea9c7668c72c87b4a6cb1215
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
