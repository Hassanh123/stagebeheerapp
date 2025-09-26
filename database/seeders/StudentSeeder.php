<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Stage;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
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

        for ($i = 11; $i <= 50; $i++) {
            $students[] = [
                'naam' => 'Student ' . $i,
                'email' => 'student' . $i . '@example.com',
            ];
        }

        foreach ($students as $index => $student) {
            // ✅ Maak of update de user
            $user = User::updateOrCreate(
                ['email' => $student['email']],
                [
                    'naam' => $student['naam'],
                    'role' => 'student',
                    'password' => Hash::make('password123'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // ✅ Maak of update de student
            Student::updateOrCreate(
                ['email' => $student['email']],
                [
                    'naam' => $student['naam'],
                    'student_number' => 'S' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'photo_url' => 'https://i.pravatar.cc/150?img=' . rand(1, 70),
                    'stage_id' => !empty($stageIds) ? $stageIds[array_rand($stageIds)] : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
