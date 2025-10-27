<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmailTemplate::insert([
            [
                'sort_order' => 1,
                'key' => 'welcome_email',
                'name' => 'Welcome Email',
                'subject' => 'Welcome to Our Platform!',
                'template' => '<p>Hi {{name}},</p><p>Welcome to our platform!</p>',
                'variables' => json_encode(['name']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 2,
                'key' => 'password_reset',
                'name' => 'Password Reset',
                'subject' => 'Reset Your Password',
                'template' => '<p>Hi {{name}},</p><p>Click <a href="{{reset_link}}">here</a> to reset your password.</p>',
                'variables' => json_encode(['name', 'reset_link']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 3,
                'key' => 'order_confirmation',
                'name' => 'Order Confirmation',
                'subject' => 'Your Order is Confirmed',
                'template' => '<p>Hi {{name}},</p><p>Your order #{{order_id}} has been confirmed.</p>',
                'variables' => json_encode(['name', 'order_id']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
