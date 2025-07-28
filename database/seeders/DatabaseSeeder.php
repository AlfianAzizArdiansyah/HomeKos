<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create(
            [
                'name' => 'Owner Kost',
                'email' => 'homekost33@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Kosku123'), // Ganti dengan password yang aman
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );
    }
}
