<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'dinamawaddah2004@gmail.com'],
            [
                'nama_lengkap' => 'Dina Mawaddah',
                'password' => Hash::make('Banjarmasin'),
                'role' => 'pengguna',
            ]
        );

        $this->command->info('User created/verified successfully!');
        $this->command->info('Email: dinamawaddah2004@gmail.com | Password: Banjarmasin');
    }
}
