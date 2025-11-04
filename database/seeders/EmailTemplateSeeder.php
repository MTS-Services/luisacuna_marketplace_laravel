<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;
use App\Models\Admin;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure at least one admin exists
        $admin = Admin::first() ?? Admin::factory()->create();

        // Create multiple email templates
        EmailTemplate::factory()
            ->count(10)
            ->create([
                'created_by' => $admin->id,
            ]);

        // Optionally, create specific predefined templates
        EmailTemplate::updateOrCreate(
            ['key' => 'user_welcome'],
            [
                'sort_order' => 1,
                'name' => 'User Welcome Email',
                'subject' => 'Welcome to Our App, {{user_name}}!',
                'template' => '<p>Hello {{user_name}}, welcome to {{app_name}}!</p>',
                'variables' => json_encode(['user_name', 'app_name']),
                'created_by' =>1,
            ]
        );
    }
}
