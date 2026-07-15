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
            ['email' => 'admin@pelayanan-k3.com'],
            [
                'nama_lengkap' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'dina26@gmail.com'],
            [
                'nama_lengkap' => 'Dina Admin',
                'password' => Hash::make('123456789'),
                'role' => 'admin',
            ]
        );

        $this->command->info('Admin users created/verified successfully!');
        $this->command->info('Email: admin@pelayanan-k3.com | Password: admin123');
        $this->command->info('Email: dina26@gmail.com | Password: 123456789');
    }
}
