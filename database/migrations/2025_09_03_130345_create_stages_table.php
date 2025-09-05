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
            $table->integer('stage_id'); 
            $table->string('titel'); 
            $table->text('beschrijving'); 
            $table->string('status'); 
            $table->integer('bedrijf_id'); 
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
