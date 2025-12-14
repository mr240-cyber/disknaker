<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // Seed Submission Data
        $this->call([
            SubmissionSeeder::class,
        ]);

        // Ensure Admin exists if not already seeded via AdminUserSeeder
        // \App\Models\User::factory()->create([...]); 
    }
}
