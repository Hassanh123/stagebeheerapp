<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
    }
}
