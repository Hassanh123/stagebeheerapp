<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            ['naam' => 'Jan Jansen', 'email' => 'jan.jansen@example.com'],
            ['naam' => 'Lisa de Vries', 'email' => 'lisa.devries@example.com'],
            ['naam' => 'Mohammed Ali', 'email' => 'mohammed.ali@example.com'],
            ['naam' => 'Sofia González', 'email' => 'sofia.gonzalez@example.com'],
            // ... add more students
        ];

        foreach ($students as $index => $student) {

            // Fetch a random user image from randomuser.me
            $response = Http::get('https://randomuser.me/api/?inc=picture');
            $picture = $response->json('results.0.picture.medium'); // medium size photo

            DB::table('students')->insert([
                'naam' => $student['naam'],
                'email' => $student['email'],
                'student_number' => 'S'.str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'photo' => $picture, // store the URL
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
