<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stage;
use App\Models\Company;
use App\Models\Teacher;
use App\Models\Tag;



class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::all();
        $teachers = Teacher::all();

        if ($companies->isEmpty() || $teachers->isEmpty()) {
            $this->command->info('Please make sure there are companies and teachers in the database first.');
            return;
        }

        $stages = [
            ['titel' => 'Introductie Programmeren', 'beschrijving' => 'Leer de basis van programmeren in verschillende talen.', 'status' => 'vrij'],
            ['titel' => 'Webontwikkeling', 'beschrijving' => 'Maak je eerste webapplicatie met HTML, CSS en JavaScript.', 'status' => 'vrij'],
            ['titel' => 'Databases en SQL', 'beschrijving' => 'Leer hoe je databases ontwerpt en queries schrijft.', 'status' => 'Bezet'],
            ['titel' => 'C# Applicaties', 'beschrijving' => 'Ontwikkel C# desktop applicaties.', 'status' => 'vrij'],
            ['titel' => 'JavaScript Frameworks', 'beschrijving' => 'Leer werken met moderne JS frameworks zoals Vue of React.', 'status' => 'vrij'],
            ['titel' => 'Mobile Development', 'beschrijving' => 'Bouw mobiele apps voor Android en iOS.', 'status' => 'vrij'],
            ['titel' => 'Cybersecurity Basics', 'beschrijving' => 'Leer de basis van cybersecurity en veilige applicaties.', 'status' => 'vrij'],
            ['titel' => 'Data Analytics', 'beschrijving' => 'Analyseer datasets en maak rapportages.', 'status' => 'vrij'],
        ];

        foreach ($stages as $index => $stageData) {
            Stage::create([
                'titel' => $stageData['titel'],
                'beschrijving' => $stageData['beschrijving'],
                'status' => $stageData['status'],
                'company_id' => $companies[$index % $companies->count()]->id,
                'teacher_id' => $teachers[$index % $teachers->count()]->id,
            ]);
        }

        $this->command->info(count($stages) . ' stages created successfully.');
    }
}
