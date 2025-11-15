<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@dev.com',
            'email_verified_at' => Carbon::now(),
            'phone' => '0000000000',
            'phone_verified_at' => Carbon::now(),
            'password' => Hash::make('superadmin@dev.com'),
        ]);
        $superadmin->assignRole('Super Admin');
        $admin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@dev.com',
            'email_verified_at' => Carbon::now(),
            'phone' => '0000000000',
            'phone_verified_at' => Carbon::now(),
            'password' => Hash::make('admin@dev.com'),
        ]);
        $superadmin->assignRole('Admin');
    }
}
