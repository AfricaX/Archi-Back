<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Artisan::call("passport:keys");

        Artisan::call("passport:client --personal --no-interaction");
        
         User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'Password123', 
            'role' => 'admin',
        ]);
    }
}
