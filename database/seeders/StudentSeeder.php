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

        $firstNames = [
            'James','Mary','John','Patricia','Robert','Jennifer','Michael','Linda',
            'William','Elizabeth','David','Barbara','Richard','Susan','Joseph','Jessica',
            'Thomas','Sarah','Charles','Karen','Christopher','Nancy','Daniel','Lisa',
            'Matthew','Betty','Anthony','Margaret','Mark','Sandra','Donald','Ashley',
            'Steven','Kimberly','Paul','Emily','Andrew','Donna','Joshua','Michelle',
            'Kenneth','Dorothy','Kevin','Carol','Brian','Amanda','George','Melissa','Edward','Deborah'
        ];

        $lastNames = [
            'Smith','Johnson','Williams','Brown','Jones','Garcia','Miller','Davis',
            'Rodriguez','Martinez','Hernandez','Lopez','Gonzalez','Wilson','Anderson','Thomas',
            'Taylor','Moore','Jackson','Martin','Lee','Perez','Thompson','White','Harris','Sanchez',
            'Clark','Ramirez','Lewis','Robinson','Walker','Young','Allen','King','Wright','Scott',
            'Torres','Nguyen','Hill','Flores','Green','Adams','Nelson','Baker','Hall','Rivera',
            'Campbell','Mitchell','Carter','Roberts'
        ];

        $students = [];

        for ($i = 1; $i <= 50; $i++) {
            $first = $firstNames[array_rand($firstNames)];
            $last = $lastNames[array_rand($lastNames)];

            $students[] = [
                'naam' => "$first $last",
                'email' => strtolower("$first.$last$i@example.com"), // uniek
            ];
        }

        foreach ($students as $index => $studentData) {
            // Maak of update de gebruiker
            $user = User::updateOrCreate(
                ['email' => $studentData['email']],
                [
                    'name' => $studentData['naam'],
                    'role' => 'student',
                    'password' => Hash::make('password'),
                ]
            );

            // Maak of update de student en koppel aan user
            Student::updateOrCreate(
                ['email' => $studentData['email']],
                [
                    'user_id' => $user->id,
                    'naam' => $studentData['naam'],
                    'student_number' => 'S' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'photo_url' => 'https://i.pravatar.cc/150?img=' . rand(1, 70),
                    'stage_id' => !empty($stageIds) ? $stageIds[array_rand($stageIds)] : null,
                ]
            );
        }
    }
}
