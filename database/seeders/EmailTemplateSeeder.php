<?php

namespace Database\Seeders;

use App\Enums\EmailTemplateEnum;
use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'key' => EmailTemplateEnum::ORDER_MESSAGE_BUYER->value,
                'name' => 'Order message to Buyer',
                'subject' => 'Order Message - {{order_id}}',
                'template' => '<p>Hello {{buyer_name}},</p><p>You have a new message regarding your order {{order_id}}.</p><p>Product: {{product_name}}</p><p>Price: {{currency}} {{price}}</p><p>Paid at: {{paid_at}}</p><p>{{app_name}} - {{date_time}}</p>',
                'variables' => ['seller_name', 'buyer_name', 'order_id', 'product_name', 'price', 'currency', 'paid_at', 'app_name', 'date_time'],
                'sort_order' => 1,
            ],
            [
                'key' => EmailTemplateEnum::ORDER_MESSAGE_SELLER->value,
                'name' => 'Order message to Seller',
                'subject' => 'Order Message - {{order_id}}',
                'template' => '<p>Hello {{seller_name}},</p><p>You have a new message regarding order {{order_id}}.</p><p>Buyer: {{buyer_name}}</p><p>Product: {{product_name}}</p><p>Price: {{currency}} {{price}}</p><p>Paid at: {{paid_at}}</p><p>{{app_name}} - {{date_time}}</p>',
                'variables' => ['seller_name', 'buyer_name', 'order_id', 'product_name', 'price', 'currency', 'paid_at', 'app_name', 'date_time'],
                'sort_order' => 2,
            ],
            [
                'key' => EmailTemplateEnum::ORDER_MESSAGE_ADMIN->value,
                'name' => 'Order message to Admin',
                'subject' => 'Order Message - {{order_id}}',
                'template' => '<p>New message on order {{order_id}}.</p><p>Seller: {{seller_name}} | Buyer: {{buyer_name}}</p><p>Product: {{product_name}}</p><p>Price: {{currency}} {{price}}</p><p>Paid at: {{paid_at}}</p><p>{{app_name}} - {{date_time}}</p>',
                'variables' => ['seller_name', 'buyer_name', 'order_id', 'product_name', 'price', 'currency', 'paid_at', 'app_name', 'date_time'],
                'sort_order' => 3,
            ],
            [
                'key' => EmailTemplateEnum::PAYMENT_SUCCESS_BUYER->value,
                'name' => 'Payment Success to Buyer',
                'subject' => 'Payment successful - Order {{order_id}}',
                'template' => '<p>Hello {{buyer_name}},</p><p>Your payment has been processed successfully.</p><p>Order ID: {{order_id}}</p><p>Product: {{product_name}}</p><p>Price: {{currency}} {{price}}</p><p>Paid at: {{paid_at}}</p><p>Payment method: {{payment_gateway}}</p><p>Transaction ID: {{payment_id}}</p><p><a href="{{order_detail_link}}">View order details</a></p><p>{{app_name}} - {{date_time}}</p>',
                'variables' => ['buyer_name', 'order_id', 'product_name', 'price', 'currency', 'paid_at', 'app_name', 'date_time', 'payment_gateway', 'payment_id'],
                'sort_order' => 4,
            ],
            [
                'key' => EmailTemplateEnum::PAYMENT_SUCCESS_SUPER_ADMIN->value,
                'name' => 'Payment Success to Super Admins',
                'subject' => 'New payment received - Order {{order_id}}',
                'template' => '<p>A new payment has been received.</p><p>Buyer: {{buyer_name}}</p><p>Order ID: {{order_id}}</p><p>Product: {{product_name}}</p><p>Amount: {{currency}} {{price}}</p><p>Paid at: {{paid_at}}</p><p>Payment method: {{payment_gateway}}</p><p>Transaction ID: {{payment_id}}</p><p>{{app_name}} - {{date_time}}</p>',
                'variables' => ['buyer_name', 'order_id', 'product_name', 'price', 'currency', 'paid_at', 'app_name', 'date_time', 'payment_gateway', 'payment_id'],
                'sort_order' => 5,
            ],
            [
                'key' => EmailTemplateEnum::PAYMENT_CANCELED_BUYER->value,
                'name' => 'Payment Canceled to Buyer',
                'subject' => 'Payment canceled - Order {{order_id}}',
                'template' => '<p>Hello {{buyer_name}},</p><p>Your payment for order {{order_id}} was canceled.</p><p>Product: {{product_name}}</p><p>Amount: {{currency}} {{price}}</p><p>Paid at: {{paid_at}}</p><p>Transaction ID: {{transaction_id}}</p><p>Payment method: {{payment_gateway}}</p><p><a href="{{order_detail_link}}">View order</a></p><p>{{app_name}} - {{date_time}}</p>',
                'variables' => ['buyer_name', 'order_id', 'product_name', 'price', 'currency', 'paid_at', 'app_name', 'date_time', 'payment_gateway', 'transaction_id'],
                'sort_order' => 6,
            ],
            [
                'key' => EmailTemplateEnum::WITHDRAWAL_REQUEST_SUBMIT_SELLER->value,
                'name' => 'Withdrawal Request Submit to Seller',
                'subject' => 'Withdrawal request submitted',
                'template' => '<p>Hello {{seller_name}},</p><p>Your withdrawal request has been submitted.</p><p>Order ID: {{order_id}}</p><p>Product: {{product_name}}</p><p>Amount: {{currency}} {{price}}</p><p>Submitted at: {{submit_at}}</p><p>{{app_name}} - {{date_time}}</p>',
                'variables' => ['seller_name', 'order_id', 'product_name', 'price', 'currency', 'submit_at', 'app_name', 'date_time'],
                'sort_order' => 7,
            ],
            [
                'key' => EmailTemplateEnum::WITHDRAWAL_REQUEST_SUBMIT_SUPER_ADMIN->value,
                'name' => 'Withdrawal Request Submit to Super Admins',
                'subject' => 'New withdrawal request - {{seller_name}}',
                'template' => '<p>A new withdrawal request has been submitted.</p><p>Seller: {{seller_name}}</p><p>Order ID: {{order_id}}</p><p>Product: {{product_name}}</p><p>Amount: {{currency}} {{price}}</p><p>Submitted at: {{submit_at}}</p><p>{{app_name}} - {{date_time}}</p>',
                'variables' => ['seller_name', 'order_id', 'product_name', 'price', 'currency', 'submit_at', 'app_name', 'date_time'],
                'sort_order' => 8,
            ],
            [
                'key' => EmailTemplateEnum::WITHDRAWAL_PROCESS_SUCCESS_SUPER_ADMIN->value,
                'name' => 'Withdrawal Process Success to Super Admins',
                'subject' => 'Withdrawal processed - {{order_id}}',
                'template' => '<p>Withdrawal has been processed successfully.</p><p>Seller: {{seller_name}}</p><p>Order ID: {{order_id}}</p><p>Product: {{product_name}}</p><p>Amount: {{currency}} {{price}}</p><p>Processed at: {{process_at}}</p><p>Transaction ID: {{transaction_id}}</p><p>{{app_name}} - {{date_time}}</p>',
                'variables' => ['seller_name', 'order_id', 'product_name', 'price', 'currency', 'process_at', 'app_name', 'date_time', 'transaction_id'],
                'sort_order' => 9,
            ],
            [
                'key' => EmailTemplateEnum::WITHDRAWAL_PROCESS_SUCCESS_SELLER->value,
                'name' => 'Withdrawal Process Success to Seller',
                'subject' => 'Withdrawal processed successfully',
                'template' => '<p>Hello {{seller_name}},</p><p>Your withdrawal has been processed successfully.</p><p>Order ID: {{order_id}}</p><p>Product: {{product_name}}</p><p>Amount: {{currency}} {{price}}</p><p>Processed at: {{process_at}}</p><p>Transaction ID: {{transaction_id}}</p><p>{{app_name}} - {{date_time}}</p>',
                'variables' => ['seller_name', 'order_id', 'product_name', 'price', 'currency', 'process_at', 'app_name', 'date_time', 'transaction_id'],
                'sort_order' => 10,
            ],
            [
                'key' => EmailTemplateEnum::USER_BANNED->value,
                'name' => 'User Banned',
                'subject' => 'Account suspended - {{app_name}}',
                'template' => '<p>Hello {{user_name}},</p><p>Your account has been suspended.</p><p>Username: {{username}}</p><p>Email: {{email}}</p><p>{{message}}</p><p>Banned at: {{banned_time}}</p><p>{{app_name}} - {{date_time}}</p>',
                'variables' => ['user_name', 'username', 'email', 'message', 'banned_time', 'app_name', 'date_time'],
                'sort_order' => 11,
            ],
            [
                'key' => EmailTemplateEnum::OTP_VERIFICATION->value,
                'name' => 'OTP Verification',
                'subject' => 'Your verification code - {{app_name}}',
                'template' => '<p>Your OTP verification code is: <strong>{{otp_code}}</strong></p><p>Email: {{email}}</p><p>Do not share this code with anyone.</p><p>{{app_name}} - {{date_time}}</p>',
                'variables' => ['email', 'otp_code', 'app_name', 'date_time'],
                'sort_order' => 12,
            ],
            [
                'key' => EmailTemplateEnum::ORDER_DISPUTE_RESOLVED_BUYER->value,
                'name' => 'Order Dispute resolved to Buyer',
                'subject' => 'Dispute resolved - Order {{order_id}}',
                'template' => '<p>Hello {{buyer_name}},</p><p>Your dispute for order {{order_id}} has been resolved.</p><p>Product: {{product_name}}</p><p>Paid at: {{paid_at}}</p><p><a href="{{order_detail_link}}">View order details</a></p><p>{{app_name}} - {{date_time}}</p>',
                'variables' => ['buyer_name', 'order_id', 'product_name', 'paid_at', 'app_name', 'date_time', 'order_detail_link'],
                'sort_order' => 13,
            ],
            [
                'key' => EmailTemplateEnum::ORDER_DISPUTE_RESOLVED_SELLER->value,
                'name' => 'Order Dispute resolved to Seller',
                'subject' => 'Dispute resolved - Order {{order_id}}',
                'template' => '<p>Hello {{seller_name}},</p><p>The dispute for order {{order_id}} has been resolved.</p><p>Buyer: {{buyer_name}}</p><p>Product: {{product_name}}</p><p>Paid at: {{paid_at}}</p><p><a href="{{order_detail_link}}">View order details</a></p><p>{{app_name}} - {{date_time}}</p>',
                'variables' => ['seller_name', 'buyer_name', 'order_id', 'product_name', 'paid_at', 'app_name', 'date_time', 'order_detail_link'],
                'sort_order' => 14,
            ],
        ];

        EmailTemplate::query()->delete();

        foreach ($templates as $data) {
            EmailTemplate::create([
                'key' => $data['key'],
                'name' => $data['name'],
                'subject' => $data['subject'],
                'template' => $data['template'],
                'variables' => $data['variables'],
                'sort_order' => $data['sort_order'],
            ]);
        }
    }
}
