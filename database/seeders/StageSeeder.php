<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stage;
use App\Models\Company;
use App\Models\Teacher;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Haal eerste company en teacher
        $company = Company::first();
        $teacher = Teacher::first();

        // Maak stages aan
        Stage::create([
            'titel' => 'Stage 1: Introductie Programmeren',
            'beschrijving' => 'Leer de basis van programmeren in verschillende talen.',
            'status' => 'vrij',
            'company_id' => $company->id,
            'teacher_id' => $teacher->id,
        ]);

        Stage::create([
            'titel' => 'Stage 2: Webontwikkeling',
            'beschrijving' => 'Maak je eerste webapplicatie met HTML, CSS en JavaScript.',
            'status' => 'vrij',
            'company_id' => $company->id,
            'teacher_id' => $teacher->id,
        ]);

        Stage::create([
            'titel' => 'Stage 3: Databases en SQL',
            'beschrijving' => 'Leer hoe je databases ontwerpt en queries schrijft.',
            'status' => 'op slot',
            'company_id' => $company->id,
            'teacher_id' => $teacher->id,
        ]);
    }
}
