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
        Schema::create('companies', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('naam');
            $table->string('adres');
            $table->string('contactpersoon');
            $table->string('email')->unique();
            $table->string('telefoon'); // standaard NOT NULL
            $table->text('beschrijving')->nullable(); // ✅ korte beschrijving
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
