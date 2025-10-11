<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'User',
            'email' => 'user@dev.com',
            'password' => 'user@dev.com',
        ]);
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@dev.com',
            'password' => 'admin@dev.com',
        ]);
        User::factory()->count(5)->create();
    }
}
