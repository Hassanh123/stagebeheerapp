<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notification_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // gebruiker die de melding ontvangt
            $table->foreignId('stage_id')->nullable()->constrained()->nullOnDelete(); // optioneel, gekoppelde stage
            $table->string('status')->nullable(); // bv. goedgekeurd, afgekeurd
            $table->string('message'); // inhoud van de melding
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
