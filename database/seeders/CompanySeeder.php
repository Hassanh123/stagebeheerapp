<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            [
                'naam' => 'TechCorp',
                'adres' => 'Straat 1, Amsterdam',
                'contactpersoon' => 'Jan Jansen',
                'email' => 'info@techcorp.nl',
                'telefoon' => '0201234567',
                'beschrijving' => 'Innovatief technologiebedrijf gespecialiseerd in web en app development.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'DesignWorks',
                'adres' => 'Straat 2, Rotterdam',
                'contactpersoon' => 'Maria de Vries',
                'email' => 'contact@designworks.nl',
                'telefoon' => '0109876543',
                'beschrijving' => 'Creatief ontwerpbureau met focus op UX/UI design en branding.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'InnovateX',
                'adres' => 'Straat 3, Utrecht',
                'contactpersoon' => 'Peter Bakker',
                'email' => 'info@innovatex.nl',
                'telefoon' => '0301122334',
                'beschrijving' => 'Startup die slimme softwareoplossingen ontwikkelt voor bedrijven.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'GreenSolutions',
                'adres' => 'Straat 4, Den Haag',
                'contactpersoon' => 'Linda Vos',
                'email' => 'contact@greensolutions.nl',
                'telefoon' => '0705566778',
                'beschrijving' => 'Duurzaam adviesbureau dat innovatieve groene IT-oplossingen aanbiedt.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'FutureTech',
                'adres' => 'Straat 5, Eindhoven',
                'contactpersoon' => 'Mark de Boer',
                'email' => 'info@futuretech.nl',
                'telefoon' => '0402233445',
                'beschrijving' => 'Hightech bedrijf gespecialiseerd in AI, IoT en automatisering.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'BlueOcean',
                'adres' => 'Straat 6, Groningen',
                'contactpersoon' => 'Sophie Meijer',
                'email' => 'contact@blueocean.nl',
                'telefoon' => '0506677889',
                'beschrijving' => 'IT-consultancy met focus op data-analyse en cloudoplossingen.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'NextGen Solutions',
                'adres' => 'Straat 7, Maastricht',
                'contactpersoon' => 'Tom van Dijk',
                'email' => 'info@nextgensolutions.nl',
                'telefoon' => '0431122334',
                'beschrijving' => 'Softwarebedrijf dat innovatieve apps en platformen ontwikkelt.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'SmartInnovations',
                'adres' => 'Straat 8, Haarlem',
                'contactpersoon' => 'Eva Janssen',
                'email' => 'contact@smartinnovations.nl',
                'telefoon' => '0234455667',
                'beschrijving' => 'Specialist in slimme softwareoplossingen en automatisering.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'AlphaTech',
                'adres' => 'Straat 9, Tilburg',
                'contactpersoon' => 'Rob de Wit',
                'email' => 'info@alphatech.nl',
                'telefoon' => '0135566778',
                'beschrijving' => 'IT-bedrijf gericht op cybersecurity en netwerkbeheer.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Creative Minds',
                'adres' => 'Straat 10, Breda',
                'contactpersoon' => 'Anne van Leeuwen',
                'email' => 'contact@creativeminds.nl',
                'telefoon' => '0763344556',
                'beschrijving' => 'Creatief collectief dat websites, apps en grafisch design ontwikkelt.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
