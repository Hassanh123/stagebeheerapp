<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            ['naam' => 'Jan Jansen', 'email' => 'jan.jansen@example.com'],
            ['naam' => 'Sofie de Vries', 'email' => 'sofie.devries@example.com'],
            ['naam' => 'Mark van Dijk', 'email' => 'mark.vandijk@example.com'],
            ['naam' => 'Lisa Smits', 'email' => 'lisa.smits@example.com'],
            ['naam' => 'Hassan Ali', 'email' => 'hassan.ali@example.com'],
            ['naam' => 'Emma van Leeuwen', 'email' => 'emma.vanleeuwen@example.com'],
            ['naam' => 'Thomas Bakker', 'email' => 'thomas.bakker@example.com'],
            ['naam' => 'Nadia Vermeer', 'email' => 'nadia.vermeer@example.com'],
            ['naam' => 'Lucas de Graaf', 'email' => 'lucas.degraaf@example.com'],
            ['naam' => 'Sara van den Berg', 'email' => 'sara.vandenberg@example.com'],
        ];

        foreach ($teachers as $teacher) {
            // ✅ Maak de user aan of update als hij al bestaat
            $user = User::updateOrCreate(
                ['email' => $teacher['email']],
                [
                    'name' => $teacher['naam'],
                    'role' => 'teacher',
                    'password' => Hash::make('Teacher123'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // ✅ Voeg teacher toe in de teachers tabel, zonder duplicaten
            Teacher::updateOrCreate(
                ['email' => $teacher['email']],
                [
                    'naam' => $teacher['naam'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
