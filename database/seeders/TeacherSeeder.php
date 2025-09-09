<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [
            [
                'naam' => 'Jan Jansen',
                'email' => 'jan.jansen@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Sofie de Vries',
                'email' => 'sofie.devries@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Mark van Dijk',
                'email' => 'mark.vandijk@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Lisa Smits',
                'email' => 'lisa.smits@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Hassan Ali',
                'email' => 'hassan.ali@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Emma van Leeuwen',
                'email' => 'emma.vanleeuwen@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Thomas Bakker',
                'email' => 'thomas.bakker@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Nadia Vermeer',
                'email' => 'nadia.vermeer@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Lucas de Graaf',
                'email' => 'lucas.degraaf@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Sara van den Berg',
                'email' => 'sara.vandenberg@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert alle teachers tegelijk
        DB::table('teachers')->insert($teachers);
    }
}
