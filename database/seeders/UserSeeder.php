<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // Create Admin User
        $admin = new User;
        $admin->name = 'Admin User';
        $admin->email = 'admin@example.com';
        $admin->password = Hash::make('password');
        $admin->role = 'admin';
        $admin->save();

        // Create Regular User
        $user = new User;
        $user->name = 'Regular User';
        $user->email = 'user@example.com';
        $user->password = Hash::make('password');
        $user->role = 'user';
        $user->save();
    }
}