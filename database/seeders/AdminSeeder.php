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
<<<<<<< Updated upstream
        $superadmin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@dev.com',
            'email_verified_at' => Carbon::now(),
            'phone' => '0000000000',
            'phone_verified_at' => Carbon::now(),
            'password' => Hash::make('superadmin@dev.com'),
=======
        Admin::insert([
            [
                'sort_order' => 1,
                'name' => 'Admin',
                'email' => 'admin@dev.com',
              
                'email_verified_at' => Carbon::now(),
                'phone' => '0000000000',
                'phone_verified_at' => Carbon::now(),
                'password' => Hash::make('admin@dev.com'),
                'avatar' => 'default.png',
                'status' => 'active',
                'two_factor_enabled' => false,
                'last_login_at' => null,
                'last_login_ip' => null,
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
>>>>>>> Stashed changes
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
