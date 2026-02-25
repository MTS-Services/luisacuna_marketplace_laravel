<?php

namespace Database\Seeders;

use App\Enums\EmailTemplateEnum;
use App\Models\EmailTemplate;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Symfony\Component\Mime\Email;

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
                'key' => EmailTemplateEnum::WELCOME_EMAIL->value,
                'name' => 'Welcome Email',
                'subject' => 'Welcome to Our Platform!',
                'template' => '<p>Hi {{name}},</p><p>Welcome to our platform!</p>',
                'variables' => json_encode(['name', 'email', 'phone', 'last_login_ip']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 4,
                'key' => EmailTemplateEnum::ORDER_DISPUTE_UPDATE->value,
                'name' => 'Dispute Resolution',
                'subject' => 'Dispute Resolution',
                'template' => '<p>Hi {{name}},</p><p>Welcome to our platform!</p>',
                'variables' => json_encode(['user_name', 'order_id', 'dispute_reason', 'price', 'dispute_url']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 2,
                'key' => EmailTemplateEnum::PASSWORD_RESET->value,
                'name' => 'Password Reset',
                'subject' => 'Reset Your Password',
                'template' => '<p>Hi {{name}},</p><p>Click <a href="{{reset_link}}">here</a> to reset your password.</p>',
                'variables' => json_encode(['name', 'reset_link',]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sort_order' => 3,
                'key'        => EmailTemplateEnum::ORDER_CONFIRMATION->value,
                'name'       => 'Order Confirmation',
                'subject'    => 'Your Order is Confirmed',
                'template'   => $this->getOrderConfirmationTemplate(),
                'variables'  => json_encode([
                    'buyer_name',
                    'order_id',
                    'payment_gateway',
                    'currency',
                    'payment_id',
                    'paid_at',
                    'order_detail_link',
                    'app_name',
                    'date_time',
                ]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);
    }


    private function getOrderConfirmationTemplate(): string
    {
        return <<<HTML
        🎉 Payment Successful!

        Hello {buyer_name},

        Great news! Your payment has been processed successfully and your order is confirmed.

        AMOUNT PAID
        {currency} {payment_id}

        Order ID: #{order_id}
        Payment Method: {payment_gateway}
        Transaction ID: {payment_id}
        Date & Time: {paid_at}

        Your order is now being processed. We'll keep you updated on the progress.

        <a href="{order_detail_link}">View Order Details</a>

        Thank you for choosing {app_name}!

        This is an automated notification. Please do not reply to this email.
        If you have any questions, contact our support team.

        © {date_time} {app_name}. All rights reserved.
        HTML;
    }
}
