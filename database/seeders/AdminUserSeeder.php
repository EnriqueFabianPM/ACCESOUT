<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Ensure the admin user does not already exist
        if (!User::where('email', '21024@virtual.utsc.edu.mx')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => '21024@virtual.utsc.edu.mx',
                'password' => Hash::make('enrique25092003'), // Use a secure password
                'is_admin' => true, // Mark this user as an admin
            ]);
        }
    }
}
