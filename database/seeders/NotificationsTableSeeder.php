<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationsTableSeeder extends Seeder
{
    public function run(): void
    {
        // pak eerste student op basis van rol
        $student = User::where('role', 'student')->first();

        if ($student) {
            // melding goedgekeurd
            Notification::create([
                'user_id' => $student->id,
                'message' => "Je keuze voor je stage is goedgekeurd. Je docent is toegewezen.",
                'read_at' => null
            ]);

            // melding afgekeurd (optioneel)
            Notification::create([
                'user_id' => $student->id,
                'message' => "Je keuze voor je stage is afgekeurd. De stage is weer beschikbaar.",
                'read_at' => null
            ]);
        }
    }
}
