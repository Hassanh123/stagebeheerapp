<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stage_tag', function (Blueprint $table) {
            $table->foreignId('stage_id')
                  ->constrained('stages')
                  ->onDelete('cascade');

            $table->foreignId('tag_id')
                  ->constrained('tags')
                  ->onDelete('cascade');

            $table->primary(['stage_id', 'tag_id']); // voorkomt duplicate
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stage_tag');
    }
};
