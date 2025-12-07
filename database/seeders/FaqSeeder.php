<?php

namespace Database\Seeders;

use App\Enums\FaqStatus;
use App\Enums\FaqType;
use App\Models\Faq;

use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::insert(
            [
                [
                    'question' => 'How do I track my order?',
                    'answer' => 'You can track your order through your dashboard under the “My Orders” section.',
                    'status' => FaqStatus::ACTIVE->value,
                    'type' => FaqType::BUYER->value,
                ],
                [
                    'question' => 'What payment methods are accepted?',
                    'answer' => 'We accept credit cards, debit cards, PayPal, and mobile banking payments.',
                    'status' => FaqStatus::ACTIVE->value,
                    'type' => FaqType::BUYER->value,
                ],
                [
                    'question' => 'Can I cancel my order?',
                    'answer' => 'Yes, you can cancel your order before it is processed by the seller.',
                    'status' =>FaqStatus::ACTIVE->value,
                    'type' => FaqType::BUYER->value,
                ],
                [
                    'question' => 'How long does delivery take?',
                    'answer' => 'Delivery typically takes 1–5 business days depending on your location.',
                    'status' => FaqStatus::ACTIVE->value,
                    'type' => FaqType::BUYER->value,
                ],
                [
                    'question' => 'Do you offer refunds?',
                    'answer' => 'Refunds are available if the item arrives damaged or is not as described.',
                    'status' => FaqStatus::ACTIVE->value,
                    'type' => FaqType::BUYER->value,
                ],
                [
                    'question' => 'How do I list a new product?',
                    'answer' => 'You can list products from your seller dashboard under the “Add Product” section.',
                    'status' =>FaqStatus::ACTIVE->value,
                    'type' => FaqType::SELLER->value,
                ],
                [
                    'question' => 'When do I receive payments?',
                    'answer' => 'Payments are released 48 hours after the order is delivered and confirmed.',
                    'status' => FaqStatus::ACTIVE->value,
                    'type' => FaqType::SELLER->value,
                ],
                [
                    'question' => 'Can I edit my product after publishing?',
                    'answer' => 'Yes, you can edit product details at any time from your product list.',
                    'status' => FaqStatus::ACTIVE->value,
                    'type' => FaqType::SELLER->value,
                ],
                [
                    'question' => 'How do I handle order cancellations?',
                    'answer' => 'Order cancellations can be managed from the “Orders” section on your dashboard.',
                    'status' => FaqStatus::ACTIVE->value,
                    'type' => FaqType::SELLER->value,
                ],
                [
                    'question' => 'Are there any selling fees?',
                    'answer' => 'Yes, a small commission fee is deducted from each successful sale.',
                    'status' => FaqStatus::ACTIVE->value,
                    'type' => FaqType::SELLER->value,
                ],
            ]

        );
    }
}
