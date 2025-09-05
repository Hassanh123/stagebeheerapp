<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@stagebeheer.local'], // uniek veld
            [
                'name' => 'admin',
                'password' => Hash::make('Admin123'), // wachtwoord versleuteld
            ]
        );
    }
}
