<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Eventueel een test user met factory (optioneel)
        // \App\Models\User::factory(10)->create();

        // Call jouw AdminUserSeeder
        $this->call(AdminUserSeeder::class);
        $this->call(TagSeeder::class);
         $this->call(CompanySeeder::class);
          $this->call(TeacherSeeder::class);
    }
}
