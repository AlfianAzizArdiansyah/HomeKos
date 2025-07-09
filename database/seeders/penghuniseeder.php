<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Penghuniseeder extends Seeder
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
                'name' => 'Penghuni 1',
                'email' => 'penghuni1@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'penghuni',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
