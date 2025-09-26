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
        // Eventueel test users met factory
        // \App\Models\User::factory(10)->create();

        // Basis seeders
        $this->call(AdminUserSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(StageSeeder::class);
        $this->call(StudentSeeder::class);

        // Seeders die afhankelijk zijn van studenten/stages
        $this->call(CoursesTableSeeder::class);
        $this->call(NotificationsTableSeeder::class);
    }
}
