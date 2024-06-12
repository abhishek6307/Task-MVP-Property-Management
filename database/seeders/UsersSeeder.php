<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an admin role if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // Create a non-admin role (user role) if it doesn't exist
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create an admin user
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Change this to a secure password
        ]);
        // Assign admin role to the admin user
        $adminUser->assignRole($adminRole);

        // Create a regular user
        $regularUser = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'), // Change this to a secure password
        ]);
        // Assign user role to the regular user
        $regularUser->assignRole($userRole);
    }
}
