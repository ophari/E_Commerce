<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        try {
            User::create(
                [
                    'email' => 'admin@example.com',
                    'name' => 'Admin Utama',
                    'password' => Hash::make('admin123'),
                    'role' => 'admin',
                ]
            );
            $this->command->info('Admin user created.');
        } catch (\Exception $e) {
            $this->command->error('Error creating admin user: ' . $e->getMessage());
        }

        // User akun
        try {
            User::create(
                [
                    'email' => 'user@example.com',
                    'name' => 'User Biasa',
                    'password' => Hash::make('user123'),
                    'role' => 'user',
                ]
            );
            $this->command->info('Regular user created.');
        } catch (\Exception $e) {
            $this->command->error('Error creating regular user: ' . $e->getMessage());
        }
    }
}
