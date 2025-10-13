<?php
// Define the Blade component props, setting smart defaults.
$show = $show ?? 'showModal';
$title = $title ?? 'Are you sure?';
$message = $message ?? 'Please confirm your action.';
$method = $method ?? 'confirmAction';
$buttonText = $buttonText ?? 'Confirm';
$iconColor = $iconColor ?? 'red'; // Supports red, blue, green, yellow, etc.

// Dynamic color classes based on the iconColor prop.
$colorBase = "text-{$iconColor}-600";
$colorBg = "bg-{$iconColor}-100";
$buttonBg = "bg-{$iconColor}-600";
$buttonHoverBg = "hover:bg-{$iconColor}-700";
$buttonFocusRing = "focus:ring-{$iconColor}-500";
?>

<div x-data="{ localShow: @entangle($show) }">
    <div x-show="localShow" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">

        {{-- Backdrop --}}
        <div @click="localShow = false" wire:click="$set('{{ $show }}', false)"
            class="fixed inset-0 bg-gray-900/50"></div>

        {{-- Centering container --}}
        <div class="flex items-center justify-center min-h-screen px-4 py-8">

            {{-- Modal Panel --}}
            <div x-show="localShow" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all">

                {{-- Close Button --}}
                <div class="absolute top-4 right-4">
                    <button @click="localShow = false" wire:click="$set('{{ $show }}', false)"
                        class="text-gray-400 hover:text-gray-600 transition-colors duration-150 rounded-full p-1 focus:outline-none focus:ring-2 focus:ring-gray-200">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Modal Content --}}
                <div class="p-8 text-center">
                    {{-- Icon (The specific icon for 'alert/delete' is kept, but its color is dynamic) --}}
                    <div
                        class="mx-auto flex items-center justify-center h-16 w-16 rounded-full {{ $colorBg }} mb-4">
                        <svg class="h-8 w-8 {{ $colorBase }}" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            {{-- Exclamation Mark Triangle Icon --}}
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.305 3.254 1.933 3.254h14.714c1.628 0 2.792-1.754 1.933-3.254L12.94 2.332c-.865-1.5-3.032-1.5-3.897 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>

                    {{-- Title --}}
                    <h3 class="text-2xl font-bold text-gray-900 mb-2" id="modal-title">
                        {{ $title }}
                    </h3>

                    {{-- Description --}}
                    <p class="text-base text-gray-600 mb-6">
                        {!! $message !!} {{-- Use {!! !!} to allow for bolding or links in the message if needed --}}
                    </p>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row justify-center gap-3">
                        {{-- Primary Action Button --}}
                        <button wire:click="{{ $method }}" @click="localShow = false" {{-- Close modal after Livewire action initiates --}}
                            class="w-full sm:w-auto px-6 py-3 rounded-xl {{ $buttonBg }} text-white text-base font-semibold shadow-sm {{ $buttonHoverBg }} focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $buttonFocusRing }} transition duration-150">
                            {{ $buttonText }}
                        </button>

                        {{-- Cancel Button --}}
                        <button wire:click="$set('{{ $show }}', false)" @click="localShow = false"
                            class="w-full sm:w-auto px-6 py-3 rounded-xl bg-white border border-gray-300 text-gray-800 text-base font-semibold shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition duration-150">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
