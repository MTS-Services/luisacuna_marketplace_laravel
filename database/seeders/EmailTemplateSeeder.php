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
                'key' => EmailTemplateEnum::ORDER_MESSAGE->value,
                'name' => 'Order Message',
                'subject' => 'Order Message - {{order_id}}',
                'template' => '<p>Hello {{buyer_name}},</p><p>You have a new message regarding your order {{order_id}}.</p><p>{{message}}</p><p>{{app_name}}</p>',
                'variables' => ['buyer_name', 'order_id', 'message', 'app_name'],
                'sort_order' => 1,
            ],
            [
                'key' => EmailTemplateEnum::NEW_MESSAGE_RECEIVED->value,
                'name' => 'New Message Received',
                'subject' => 'New message received',
                'template' => '<p>Hello {{recipient_name}},</p><p>You have received a new message from {{sender_name}}.</p><p>{{message}}</p><p>{{app_name}}</p>',
                'variables' => ['recipient_name', 'sender_name', 'message', 'app_name'],
                'sort_order' => 2,
            ],
            [
                'key' => EmailTemplateEnum::ORDER_STATUS_CHANGED->value,
                'name' => 'Order Status Changed',
                'subject' => 'Order {{order_id}} status updated',
                'template' => '<p>Hello {{buyer_name}},</p><p>Your order {{order_id}} status has been updated to {{status}}.</p><p>{{order_detail_link}}</p><p>{{app_name}}</p>',
                'variables' => ['buyer_name', 'order_id', 'status', 'order_detail_link', 'app_name'],
                'sort_order' => 3,
            ],
            [
                'key' => EmailTemplateEnum::ORDER_DISPUTE->value,
                'name' => 'Order Dispute',
                'subject' => 'Dispute update for order {{order_id}}',
                'template' => '<p>Hello {{user_name}},</p><p>There is an update regarding the dispute for order {{order_id}}.</p><p>{{dispute_reason}}</p><p>{{dispute_url}}</p><p>{{app_name}}</p>',
                'variables' => ['user_name', 'order_id', 'dispute_reason', 'price', 'dispute_url', 'app_name'],
                'sort_order' => 4,
            ],
            [
                'key' => EmailTemplateEnum::PAYMENT->value,
                'name' => 'Payment',
                'subject' => 'Payment successful - Order {{order_id}}',
                'template' => '<p>Hello {{buyer_name}},</p><p>Your payment has been processed successfully.</p><p>Order ID: {{order_id}}</p><p>Amount: {{currency}}</p><p>Payment method: {{payment_gateway}}</p><p><a href="{{order_detail_link}}">View order details</a></p><p>{{app_name}} - {{date_time}}</p>',
                'variables' => ['buyer_name', 'order_id', 'payment_gateway', 'currency', 'payment_id', 'paid_at', 'order_detail_link', 'app_name', 'date_time'],
                'sort_order' => 5,
            ],
            [
                'key' => EmailTemplateEnum::WITHDRAWAL->value,
                'name' => 'Withdrawal',
                'subject' => 'Withdrawal {{status}}',
                'template' => '<p>Hello {{user_name}},</p><p>Your withdrawal request has been {{status}}.</p><p>Amount: {{amount}}</p><p>Method: {{withdrawal_method}}</p><p>{{app_name}}</p>',
                'variables' => ['user_name', 'status', 'amount', 'withdrawal_method', 'app_name'],
                'sort_order' => 6,
            ],
            [
                'key' => EmailTemplateEnum::VERIFICATION->value,
                'name' => 'Verification',
                'subject' => 'Verify your account',
                'template' => '<p>Hello {{name}},</p><p>Please verify your account by clicking the link below.</p><p><a href="{{verification_link}}">Verify account</a></p><p>{{app_name}}</p>',
                'variables' => ['name', 'verification_link', 'app_name'],
                'sort_order' => 7,
            ],
            [
                'key' => EmailTemplateEnum::BOOSTING_OFFER->value,
                'name' => 'Boosting Offer',
                'subject' => 'Boosting offer - {{offer_title}}',
                'template' => '<p>Hello {{buyer_name}},</p><p>Check out this boosting offer: {{offer_title}}.</p><p>{{offer_description}}</p><p>{{offer_link}}</p><p>{{app_name}}</p>',
                'variables' => ['buyer_name', 'offer_title', 'offer_description', 'offer_link', 'app_name'],
                'sort_order' => 8,
            ],
        ];

        foreach ($templates as $data) {
            EmailTemplate::updateOrCreate(
                ['key' => $data['key']],
                [
                    'name' => $data['name'],
                    'subject' => $data['subject'],
                    'template' => $data['template'],
                    'variables' => $data['variables'],
                    'sort_order' => $data['sort_order'],
                ]
            );
        }
    }
}
