<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@stagebeheer.local'], // uniek veld
            [
                'naam' => 'admin',
                'role' => 'admin', // <-- voeg deze regel toe
                'password' => Hash::make('Admin123'),
            ]
        );
    }
}
