<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Stage;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Get all stage IDs
        $stageIds = Stage::pluck('id')->toArray();

        $students = [
            ['naam' => 'Jan Jansen', 'email' => 'jan.jansen@example.com'],
            ['naam' => 'Lisa de Vries', 'email' => 'lisa.devries@example.com'],
            ['naam' => 'Mohammed Ali', 'email' => 'mohammed.ali@example.com'],
            ['naam' => 'Sofia González', 'email' => 'sofia.gonzalez@example.com'],
            ['naam' => 'Ethan Chen', 'email' => 'ethan.chen@example.com'],
            ['naam' => 'Amina Hassan', 'email' => 'amina.hassan@example.com'],
            ['naam' => 'David O’Connor', 'email' => 'david.oconnor@example.com'],
            ['naam' => 'Yuki Tanaka', 'email' => 'yuki.tanaka@example.com'],
            ['naam' => 'Carlos Ramirez', 'email' => 'carlos.ramirez@example.com'],
            ['naam' => 'Fatima Zahra', 'email' => 'fatima.zahra@example.com'],
        ];

        // Generate additional students to reach 50
        for ($i = 11; $i <= 50; $i++) {
            $students[] = [
                'naam' => 'Student ' . $i,
                'email' => 'student' . $i . '@example.com',
            ];
        }

        foreach ($students as $index => $student) {

            // Maak eerst een user aan voor deze student
            $userId = DB::table('users')->insertGetId([
                'naam' => $student['naam'],    // <-- hier 'name' gebruiken
                'email' => $student['email'],
                'role' => 'student',
                'password' => bcrypt('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Voeg vervolgens de student toe met user_id
            DB::table('students')->insert([
                'user_id' => $userId,
                'naam' => $student['naam'],
                'email' => $student['email'],
                'student_number' => 'S' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'photo_url' => 'https://i.pravatar.cc/150?img=' . rand(1, 70),
                'stage_id' => !empty($stageIds) ? $stageIds[array_rand($stageIds)] : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
