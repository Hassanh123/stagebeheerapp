<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@stagebeheer.local'], // uniek veld
            [
                'naam' => 'admin',
                'role' => 'admin', // rol declareren
                'password' => Hash::make('Admin123'), // standaard wachtwoord
            ]
        );
    }
}
