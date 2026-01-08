<section class="sm:bg-bg-secondary rounded-2xl sm:p-15 md:p-20 mt-20">
    <h2 class="text-2xl sm:text-3xl font-semibold text-text-white mb-6">{{ __('Email notifications') }}</h2>

    <div class="space-y-4 bg-bg-info p-10 rounded-xl">
        <label class="flex items-center justify-between py-3 border-zinc-500 border-b">
            <span class="text-xl text-text-white cursor-pointer flex-1">{{ __('All Email Notifications') }}</span>
            <span class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.live="all_notifications"
                    class="toggle bg-zinc-50/20 checked:bg-white before:bg-white checked:before:bg-zinc-500">
            </span>
        </label>

        @php
            $fields = [
                'new_order' => ['title' => 'New Order', 'desc' => 'When you receive a new order'],
                'new_message' => ['title' => 'Message Received', 'desc' => 'When you receive a new message'],
                'order_update' => ['title' => 'Order Updates', 'desc' => 'When your order status changes'],
                'dispute_update' => ['title' => 'Dispute Updates', 'desc' => 'When your dispute resolved or updated'],
                'payment_update' => [
                    'title' => 'Payment Updates',
                    'desc' => 'When your payment is received or refunded',
                ],
                'withdrawal_update' => ['title' => 'Withdrawal Updates', 'desc' => 'When you request a withdrawal'],
                'verification_update' => [
                    'title' => 'Verification Updates',
                    'desc' => 'When your verification is processed',
                ],
                'boosting_offer' => ['title' => 'Boosting Offer', 'desc' => 'When you receive boosting offers'],
            ];
        @endphp

        @foreach ($fields as $key => $info)
            <label class="flex items-center justify-between py-3">
                <span class="text-xl text-text-white cursor-pointer flex-1">
                    {{ __($info['title']) }}
                    <span class="text-sm text-text-muted justify-start block">{{ __($info['desc']) }}</span>
                </span>
                <span class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model.live="settings.{{ $key }}"
                        class="toggle bg-zinc-50/20 checked:bg-white before:bg-white checked:before:bg-zinc-500">
                </span>
            </label>
        @endforeach
    </div>
</section>
