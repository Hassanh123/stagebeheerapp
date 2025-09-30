<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CoursesTableSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'naam' => 'Laravel Basis',
                'beschrijving' => 'Leer de basisprincipes van het Laravel framework.'
            ],
            [
                'naam' => 'Geavanceerde PHP',
                'beschrijving' => 'Verdiep je in geavanceerde PHP onderwerpen.'
            ],
            [
                'naam' => 'Webontwikkeling voor beginners',
                'beschrijving' => 'Maak kennis met HTML, CSS en JavaScript.'
            ],
            [
                'naam' => 'Databasebeheer',
                'beschrijving' => 'Leer werken met MySQL en databaseconcepten.'
            ],
            [
                'naam' => 'API Ontwikkeling',
                'beschrijving' => 'Bouw en beheer RESTful API’s.'
            ],
            [
                'naam' => 'Laravel Advanced',
                'beschrijving' => 'Diepgaande Laravel technieken en best practices.'
            ]
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
