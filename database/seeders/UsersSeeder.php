<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        //Jelszó: password
        $plainPassword = 'password';
        $hashedPassword = Hash::make($plainPassword); 

        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'role' => 'super_admin',
            'password' => $hashedPassword,
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => $hashedPassword,
        ]);

        $user = User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'role' => 'user',
            'password' => $hashedPassword,
        ]);

        $superAdmin->profile()->create([
            'full_name' => 'Super Admin User',
            'phone_number' => '+36201234567',
            'address' => '1234 Main St',
            'city' => 'Budapest',
        ]);

        $admin->profile()->create([
            'full_name' => 'Admin User',
            'phone_number' => '+36701234567',
            'address' => '1235 Main St',
            'city' => 'Budapest',
        ]);

        $user->profile()->create([
            'full_name' => 'John Doe Profile',
            'phone_number' => '+36301234567',
            'address' => '1236 Main St',
            'city' => 'Budapest',
        ]);
    }
}
