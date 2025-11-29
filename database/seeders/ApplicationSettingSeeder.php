<?php

namespace Database\Seeders;

use App\Models\ApplicationSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // General Settings
        ApplicationSetting::create([
            'key' => 'app_name',
            'value' => 'Laravel',
        ]);
        ApplicationSetting::create([
            'key' => 'short_name',
            'value' => 'LV',
        ]);
        ApplicationSetting::create([
            'key' => 'timezone',
            'value' => 'Asia/Dhaka',
        ]);
        ApplicationSetting::create([
            'key' => 'date_format',
            'value' => 'd/m/Y',
        ]);
        ApplicationSetting::create([
            'key' => 'time_format',
            'value' => 'H:i:s',
        ]);
        ApplicationSetting::create([
            'key' => 'favicon',
            'value' => 'laravel',
        ]);
        ApplicationSetting::create([
            'key' => 'app_logo',
            'value' => '',
        ]);
        ApplicationSetting::create([
            'key' => 'theme_mode',
            'value' => 'light',
        ]);
        ApplicationSetting::create([
            'key' => 'public_registration',
            'value' => '1',
        ]);
        ApplicationSetting::create([
            'key' => 'registration_approval',
            'value' => '1',
        ]);
        ApplicationSetting::create([
            'key' => 'environment',
            'value' => '1',
        ]);
        ApplicationSetting::create([
            'key' => 'app_debug',
            'value' => '1',
        ]);
        ApplicationSetting::create([
            'key' => 'debugbar',
            'value' => '1',
        ]);

        // Database Setting
        ApplicationSetting::create([
            'key' => 'database_driver',
            'value' => '1',
        ]);
        ApplicationSetting::create([
            'key' => 'database_host',
            'value' => '1',
        ]);
        ApplicationSetting::create([
            'key' => 'database_port',
            'value' => '1',
        ]);
        ApplicationSetting::create([
            'key' => 'database_name',
            'value' => '1',
        ]);
        ApplicationSetting::create([
            'key' => 'database_username',
            'value' => '1',
        ]);
        ApplicationSetting::create([
            'key' => 'database_password',
            'value' => '1',
        ]);

        // SMTP Setting
        ApplicationSetting::create([
            'key' => 'smtp_driver',
            'value' => 'smtp',
        ]);
        ApplicationSetting::create([
            'key' => 'smtp_host',
            'value' => '1',
        ]);
        ApplicationSetting::create([
            'key' => 'smtp_port',
            'value' => '1',
        ]);
        ApplicationSetting::create([
            'key' => 'smtp_encryption',
            'value' => 'tls',
        ]);
        ApplicationSetting::create([
            'key' => 'smtp_username',
            'value' => '123456',
        ]);
        ApplicationSetting::create([
            'key' => 'smtp_password',
            'value' => '123',
        ]);
        ApplicationSetting::create([
            'key' => 'smtp_from_address',
            'value' => 'superadmin@gmail.com',
        ]);
        ApplicationSetting::create([
            'key' => 'smtp_from_name',
            'value' => 'Super Admin',
        ]);
    }
}
