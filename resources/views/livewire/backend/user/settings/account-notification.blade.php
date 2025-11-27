 <section class="sm:bg-bg-primary rounded-2xl sm:p-15 md:20">
     <h2 class="text-2xl sm:text-3xl font-semibold text-text-white mb-6">{{ __('Email notifications') }}
     </h2>

     <div class="space-y-4">
         @php
             $notifications = [
                 [
                     'key' => 'manage_notification',
                     'label' => 'Manage notification',
                     'sub_title' => 'When you receive a new order.',
                 ],
                 [
                     'key' => 'new_update',
                     'label' => 'New update',
                     'sub_title' => 'When you receive a new message',
                 ],
                 [
                     'key' => 'new_request',
                     'label' => 'New request',
                     'sub_title' => 'When your order status changes',
                 ],
                 [
                     'key' => 'message_received',
                     'label' => 'Message received',
                     'sub_title' => 'When your dispute is resolved or updated',
                 ],
                 [
                     'key' => 'status_changed',
                     'label' => 'Status changed',
                     'sub_title' => 'When your payment is received or refunded',
                 ],
                 [
                     'key' => 'request_rejected',
                     'label' => 'Request rejected',
                     'sub_title' => 'When you request a withdrawal, and when it is processed',
                 ],
                 [
                     'key' => 'dispute_created',
                     'label' => 'Dispute created',
                     'sub_title' => 'When your verification is processed or updated',
                 ],
                 [
                     'key' => 'payment_received',
                     'label' => 'Payment received',
                     'sub_title' => 'When you receive boosting offers or updates',
                 ],
             ];
         @endphp

         {{-- @foreach ($notifications as $notification)
             <div class="flex items-center justify-between py-3  border-zinc-200 dark:border-zinc-800 last:border-b-0">
                 <label class="text-xl text-text-white cursor-pointer flex-1">
                     {{ __('New update') }}
                     <span class="text-sm text-text-muted justify-start block">{{ $notification['sub_title'] }}</span>
                 </label>
                 <label class="relative inline-flex items-center cursor-pointer">
                     <input type="checkbox" name="notifications[{{ $notification['key'] }}]" class="sr-only peer">
                     <div
                         class="w-11 h-6 bg-zinc-200/80 dark:bg-zinc-200/50 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent">
                     </div>
                 </label>
             </div>
         @endforeach --}}

         <div class="flex items-center justify-between py-3  border-zinc-200 dark:border-zinc-800 last:border-b-0">
             <label class="text-xl text-text-white cursor-pointer flex-1">
                 {{ __('Manage notification') }}
                 <span
                     class="text-sm text-text-muted justify-start block">{{ __('When you receive a new order.') }}</span>
             </label>
             <label class="relative inline-flex items-center cursor-pointer">
                 <input type="checkbox" name="new_order" wire:model.live="new_order" class="sr-only peer">
                 <div
                     class="w-11 h-6 bg-zinc-200/80 dark:bg-zinc-200/50 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent">
                 </div>
             </label>
         </div>
         <div class="flex items-center justify-between py-3  border-zinc-200 dark:border-zinc-800 last:border-b-0">
             <label class="text-xl text-text-white cursor-pointer flex-1">
                 {{ __('New update') }}
                 <span
                     class="text-sm text-text-muted justify-start block">{{ __('When you receive a new message') }}</span>
             </label>
             <label class="relative inline-flex items-center cursor-pointer">
                 <input type="checkbox" name="new_update" wire:model.live="new_update" class="sr-only peer">
                 <div
                     class="w-11 h-6 bg-zinc-200/80 dark:bg-zinc-200/50 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent">
                 </div>
             </label>
         </div>
         <div class="flex items-center justify-between py-3  border-zinc-200 dark:border-zinc-800 last:border-b-0">
             <label class="text-xl text-text-white cursor-pointer flex-1">
                 {{ __('New request') }}
                 <span
                     class="text-sm text-text-muted justify-start block">{{ __('When your order status changes') }}</span>
             </label>
             <label class="relative inline-flex items-center cursor-pointer">
                 <input type="checkbox" name="new_request" wire:model.live="new_request" class="sr-only peer">
                 <div
                     class="w-11 h-6 bg-zinc-200/80 dark:bg-zinc-200/50 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent">
                 </div>
             </label>
         </div>
         <div class="flex items-center justify-between py-3  border-zinc-200 dark:border-zinc-800 last:border-b-0">
             <label class="text-xl text-text-white cursor-pointer flex-1">
                 {{ __('Message received') }}
                 <span
                     class="text-sm text-text-muted justify-start block">{{ __('When your dispute is resolved or updated') }}</span>
             </label>
             <label class="relative inline-flex items-center cursor-pointer">
                 <input type="checkbox" name="message_received" wire:model.live="message_received" class="sr-only peer">
                 <div
                     class="w-11 h-6 bg-zinc-200/80 dark:bg-zinc-200/50 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent">
                 </div>
             </label>
         </div>
         <div class="flex items-center justify-between py-3  border-zinc-200 dark:border-zinc-800 last:border-b-0">
             <label class="text-xl text-text-white cursor-pointer flex-1">
                 {{ __('Status changed') }}
                 <span
                     class="text-sm text-text-muted justify-start block">{{ __('When your payment is received or refunded') }}</span>
             </label>
             <label class="relative inline-flex items-center cursor-pointer">
                 <input type="checkbox" name="status_changed" wire:model.live="status_changed" class="sr-only peer">
                 <div
                     class="w-11 h-6 bg-zinc-200/80 dark:bg-zinc-200/50 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent">
                 </div>
             </label>
         </div>
         <div class="flex items-center justify-between py-3  border-zinc-200 dark:border-zinc-800 last:border-b-0">
             <label class="text-xl text-text-white cursor-pointer flex-1">
                 {{ __('Request rejected') }}
                 <span
                     class="text-sm text-text-muted justify-start block">{{ __('When you request a withdrawal, and when it is processed') }}</span>
             </label>
             <label class="relative inline-flex items-center cursor-pointer">
                 <input type="checkbox" name="request_rejected" wire:model.live="request_rejected" class="sr-only peer">
                 <div
                     class="w-11 h-6 bg-zinc-200/80 dark:bg-zinc-200/50 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent">
                 </div>
             </label>
         </div>
         <div class="flex items-center justify-between py-3  border-zinc-200 dark:border-zinc-800 last:border-b-0">
             <label class="text-xl text-text-white cursor-pointer flex-1">
                 {{ __('Dispute created') }}
                 <span
                     class="text-sm text-text-muted justify-start block">{{ __('When your verification is processed or updated') }}</span>
             </label>
             <label class="relative inline-flex items-center cursor-pointer">
                 <input type="checkbox" name="dispute_created" wire:model.live="dispute_created" class="sr-only peer">
                 <div
                     class="w-11 h-6 bg-zinc-200/80 dark:bg-zinc-200/50 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent">
                 </div>
             </label>
         </div>
         <div class="flex items-center justify-between py-3  border-zinc-200 dark:border-zinc-800 last:border-b-0">
             <label class="text-xl text-text-white cursor-pointer flex-1">
                 {{ __('Payment received') }}
                 <span
                     class="text-sm text-text-muted justify-start block">{{ __('When you receive boosting offers or updates') }}</span>
             </label>
             <label class="relative inline-flex items-center cursor-pointer">
                 <input type="checkbox" name="payment_received" wire:model.live="payment_received" class="sr-only peer">
                 <div
                     class="w-11 h-6 bg-zinc-200/80 dark:bg-zinc-200/50 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent">
                 </div>
             </label>
         </div>
     </div>
 </section>
