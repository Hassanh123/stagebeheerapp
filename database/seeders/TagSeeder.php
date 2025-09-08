<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['naam' => 'Java', 'created_at' => now(), 'updated_at' => now()],
            ['naam' => 'Designer', 'created_at' => now(), 'updated_at' => now()],
            ['naam' => 'Laravel', 'created_at' => now(), 'updated_at' => now()],
            ['naam' => 'React', 'created_at' => now(), 'updated_at' => now()],
            ['naam' => 'Python', 'created_at' => now(), 'updated_at' => now()],
            ['naam' => 'Node.js', 'created_at' => now(), 'updated_at' => now()],
            ['naam' => 'DevOps', 'created_at' => now(), 'updated_at' => now()],
            ['naam' => 'Cloud', 'created_at' => now(), 'updated_at' => now()],
            ['naam' => 'Mobile Development', 'created_at' => now(), 'updated_at' => now()],
            ['naam' => 'QA / Testing', 'created_at' => now(), 'updated_at' => now()],
        ];

        Tag::insert($tags); // nu worden created_at en updated_at gevuld
    }
}
