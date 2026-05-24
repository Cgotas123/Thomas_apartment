<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create Admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@thomas-apartment.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Create Caretaker user
        $caretaker = User::create([
            'name' => 'Caretaker',
            'email' => 'caretaker@thomas-apartment.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $caretaker->assignRole('caretaker');
    }
}
