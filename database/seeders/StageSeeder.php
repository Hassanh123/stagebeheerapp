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
        $companies = Company::all();
        $teachers = Teacher::all();

        if ($companies->isEmpty() || $teachers->isEmpty()) {
            $this->command->info('Please make sure there are companies and teachers in the database first.');
            return;
        }

        $stages = [
            [
                'titel' => 'Introductie Programmeren',
                'beschrijving' => 'Tijdens deze stage maak je kennis met de basisprincipes van programmeren in talen zoals Python, Java en PHP. Je leert hoe je logica opbouwt, eenvoudige applicaties schrijft en code test. Deze stage is ideaal voor studenten die hun eerste stappen willen zetten in de IT-wereld.',
                'status' => 'vrij'
            ],
            [
                'titel' => 'Webontwikkeling',
                'beschrijving' => 'In deze stage bouw je een complete webapplicatie van A tot Z met HTML, CSS en JavaScript. Je krijgt inzicht in frontend en backend technieken en leert hoe je moderne tools inzet. Het doel is een functionele website te ontwikkelen die aansluit bij de praktijk.',
                'status' => 'vrij'
            ],
            [
                'titel' => 'Databases en SQL',
                'beschrijving' => 'Je gaat aan de slag met het ontwerpen en optimaliseren van relationele databases. Je leert tabellen opzetten, joins maken en complexe queries schrijven. Daarnaast ga je praktijkcases uitvoeren om rapportages en analyses uit echte datasets te halen.',
                'status' => 'vrij'
            ],
            [
                'titel' => 'C# Applicaties',
                'beschrijving' => 'Tijdens deze stage ontwikkel je desktopapplicaties in C#. Je leert werken met Windows Forms of WPF en verdiept je in objectgeoriënteerd programmeren. Samen met je begeleider werk je aan een project dat direct toegepast kan worden in de praktijk.',
                'status' => 'vrij'
            ],
            [
                'titel' => 'JavaScript Frameworks',
                'beschrijving' => 'In deze stage leer je werken met moderne JavaScript frameworks zoals Vue.js of React. Je krijgt inzicht in component-based development en gaat een dynamische, interactieve webapplicatie bouwen. De nadruk ligt op gebruiksvriendelijkheid en performance.',
                'status' => 'vrij'
            ],
            [
                'titel' => 'Mobile Development',
                'beschrijving' => 'Je ontwikkelt mobiele applicaties voor Android en iOS met behulp van frameworks zoals Flutter of React Native. Tijdens de stage werk je aan een echte app die functies bevat zoals push notificaties, dataverwerking en koppelingen met een backend.',
                'status' => 'vrij'
            ],
            [
                'titel' => 'Cybersecurity Basics',
                'beschrijving' => 'Deze stage richt zich op de basis van cybersecurity. Je leert kwetsbaarheden analyseren, eenvoudige penetratietests uitvoeren en aanbevelingen doen om applicaties veiliger te maken. Je draait mee in een team en werkt mee aan awareness-campagnes binnen het bedrijf.',
                'status' => 'vrij'
            ],
            [
                'titel' => 'Data Analytics',
                'beschrijving' => 'Tijdens deze stage leer je datasets analyseren en visualiseren met tools zoals Excel, Power BI of Python. Je ontwikkelt dashboards en rapportages die bedrijven helpen om betere beslissingen te nemen. Ook ga je werken met echte data uit de praktijk.',
                'status' => 'vrij'
            ],
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
