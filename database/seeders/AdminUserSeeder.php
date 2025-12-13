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
        User::create([
            'nama_lengkap' => 'Administrator',
            'email' => 'admin@pelayanan-k3.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@pelayanan-k3.com');
        $this->command->info('Password: admin123');
    }
}
