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
        // Create Admin User
        \App\Models\User::firstOrCreate(
            ['email' => 'syauqi032@gmail.com'],
            [
                'nama_lengkap' => 'Admin K3',
                'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Seed Submission Data (creates regular users)
        $this->call([
            SubmissionSeeder::class,
        ]);
    }
}
