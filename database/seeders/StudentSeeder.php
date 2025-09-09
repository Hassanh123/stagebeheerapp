<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
<<<<<<< HEAD
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
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
            ['naam' => 'Lars Svensson', 'email' => 'lars.svensson@example.com'],
            ['naam' => 'Priya Kapoor', 'email' => 'priya.kapoor@example.com'],
            ['naam' => 'Ahmed Mustafa', 'email' => 'ahmed.mustafa@example.com'],
            ['naam' => 'Emily Thompson', 'email' => 'emily.thompson@example.com'],
            ['naam' => 'Hiroshi Yamamoto', 'email' => 'hiroshi.yamamoto@example.com'],
            ['naam' => 'Olivia Brown', 'email' => 'olivia.brown@example.com'],
            ['naam' => 'Samuel Lee', 'email' => 'samuel.lee@example.com'],
            ['naam' => 'Nadia Petrova', 'email' => 'nadia.petrova@example.com'],
            ['naam' => 'Mateo Silva', 'email' => 'mateo.silva@example.com'],
            ['naam' => 'Chloe Martin', 'email' => 'chloe.martin@example.com'],
        ];

        // Generate 30 more random students
        for ($i = 21; $i <= 50; $i++) {
            $students[] = [
                'naam' => 'Student '.$i,
                'email' => 'student'.$i.'@example.com',
            ];
        }

        // Insert all students with student_number and timestamps
        foreach ($students as $index => $student) {
            DB::table('students')->insert([
                'naam' => $student['naam'],
                'email' => $student['email'],
                'student_number' => 'S'.str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
=======
use App\Models\Student;
use App\Models\Stage;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kies een stage die vrij is
        $stage = Stage::where('status', 'vrij')->first();

        Student::create([
            'naam' => 'Jan Jansen',
            'email' => 'jan.jansen@example.com',
            'stage_id' => $stage->id,
        ]);

        Student::create([
            'naam' => 'Lisa de Vries',
            'email' => 'lisa.devries@example.com',
            'stage_id' => $stage->id,
        ]);
>>>>>>> fb3659679fb7b861ea9c7668c72c87b4a6cb1215
    }
}
