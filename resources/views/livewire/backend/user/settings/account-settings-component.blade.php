<section class="min-h-screen bg-bg-secondary py-8">
    <section class=" mx-auto px-4">
        {{-- Header Section --}}
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-text-primary">{{ __('Account settings') }}</h1>
            <x-ui.button href="{{ route('user.purchased-orders') }}" class="sm:w-auto! py-2!">
                {{ __('Go to site') }}
            </x-ui.button>
        </div>

        <div class=" mx-auto space-y-6">
            {{-- Profile Section --}}
            <section class="glass-card rounded-2xl p-6">
                <h2 class="text-xl font-semibold text-text-primary mb-6">{{ __('Profile') }}</h2>

                {{-- Profile Image --}}
                <div class="flex items-start bg-zinc-50/10 rounded-lg gap-6 p-5 mb-6">
                    <div class="relative">
                        <img src="{{ auth()->user()->avatar ?? asset('images/default-avatar.png') }}" alt="Profile"
                            class="w-20 h-20 rounded-full object-cover ring-2 ring-accent/20">

                    </div>
                    <div class="flex-col">
                        <x-ui.button href="{{ route('user.purchased-orders') }}" class="sm:w-auto! py-2!">
                            {{ __('Upload image') }}
                        </x-ui.button>
                    </div>
                </div>

                {{-- Bio Textarea --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-text-primary mb-2">{{ __('Bio') }}</label>
                    <div class="relative">
                        <textarea name="bio" rows="4"
                            class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-3 text-text-primary placeholder:text-text-muted focus:outline-hidden focus:ring-2 focus:ring-accent resize-none"
                            placeholder="Write a short bio about yourself...">{{ old('bio', auth()->user()->bio ?? 'I am a marketing expert with passion to serve you with impactful content') }}</textarea>
                        <button class="absolute top-3 right-3 text-text-muted hover:text-text-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Save Button --}}
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-2.5 bg-accent hover:bg-accent/90 text-white rounded-lg font-medium text-sm">
                        Save changes
                    </button>
                </div>
            </section>

            {{-- Profile Details Section --}}
            <section class="glass-card rounded-2xl p-6">
                <h2 class="text-xl font-semibold text-text-primary mb-6">{{ __('Profile') }}</h2>

                <form class="space-y-5">
                    {{-- User Name --}}
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-2">{{ __('User name') }}</label>
                        <div class="relative">
                            <input type="text" name="username"
                                value="{{ old('username', auth()->user()->username ?? '') }}"
                                class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                placeholder="Enter username">
                            <button type="button"
                                class="absolute top-1/2 -translate-y-1/2 right-3 text-text-muted hover:text-text-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Company Name --}}
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-2">{{ __('Company') }}</label>
                        <div class="relative">
                            <input type="text" name="company"
                                value="{{ old('company', auth()->user()->company ?? '') }}"
                                class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                placeholder="Enter company name">
                            <button type="button"
                                class="absolute top-1/2 -translate-y-1/2 right-3 text-text-muted hover:text-text-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-2">{{ __('Email') }}</label>
                        <div class="relative">
                            <input type="email" name="email"
                                value="{{ old('email', auth()->user()->email ?? '') }}"
                                class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                placeholder="Enter email">
                            <span
                                class="absolute top-1/2 -translate-y-1/2 right-3 text-xs text-text-muted bg-bg-primary px-2 py-1 rounded">
                                {{ __('This field is linked and can only be filled in once for user') }}
                            </span>
                        </div>
                    </div>

                    {{-- Location --}}
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-2">{{ __('Location') }}</label>
                        <div class="relative">
                            <input type="text" name="location"
                                value="{{ old('location', auth()->user()->location ?? '') }}"
                                class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                placeholder="Enter location">
                            <button type="button"
                                class="absolute top-1/2 -translate-y-1/2 right-3 text-text-muted hover:text-text-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- URL --}}
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-2">{{ __('URL') }}</label>
                        <div class="relative">
                            <input type="url" name="url" value="{{ old('url', auth()->user()->url ?? '') }}"
                                class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                placeholder="https://">
                            <button type="button"
                                class="absolute top-1/2 -translate-y-1/2 right-3 text-text-muted hover:text-text-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-text-muted mt-1.5">
                            {{ __('You\'re only e-mails to other. You can type your URL here, and we will redirect them to your
                                                        personal website or their site') }}
                        </p>
                    </div>

                    {{-- Social Links --}}
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-2">Social links</label>
                        <div class="relative">
                            <input type="text" name="social_links"
                                value="{{ old('social_links', auth()->user()->social_links ?? '') }}"
                                class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                placeholder="Add social media links">
                            <button type="button"
                                class="absolute top-1/2 -translate-y-1/2 right-3 text-text-muted hover:text-text-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-text-muted mt-1.5">
                            {{__('This is the list of social media platforms or accounts you are associated with. Use commas
                            to distinguish')}}
                        </p>
                    </div>
                </form>
            </section>

            {{-- Email Notifications Section --}}
            <section class="bg-zinc-50/10 rounded-2xl p-6">
                <h2 class="text-xl font-semibold text-text-primary mb-6">{{__('Email notifications')}}</h2>

                <div class="space-y-4">
                    @php
                        $notifications = [
                            ['key' => 'manage_notification', 'label' => 'Manage notification'],
                            ['key' => 'new_update', 'label' => 'New update'],
                            ['key' => 'new_request', 'label' => 'New request'],
                            ['key' => 'message_received', 'label' => 'Message received'],
                            ['key' => 'status_changed', 'label' => 'Status changed'],
                            ['key' => 'request_rejected', 'label' => 'Request rejected'],
                            ['key' => 'dispute_created', 'label' => 'Dispute created'],
                            ['key' => 'payment_received', 'label' => 'Payment received'],
                            ['key' => 'activity_mention', 'label' => 'Activity mention'],
                            ['key' => 'announcement_updates', 'label' => 'Announcement and updates'],
                            ['key' => 'profile_updates', 'label' => 'Profile updates'],
                            ['key' => 'reminders', 'label' => 'Reminders'],
                            ['key' => 'events_offers', 'label' => 'Events & Offers'],
                        ];
                    @endphp

                    @foreach ($notifications as $notification)
                        <div
                            class="flex items-center justify-between py-3  border-zinc-200 dark:border-zinc-800 last:border-b-0">
                            <label class="text-sm text-text-primary cursor-pointer flex-1">
                                {{ $notification['label'] }}
                            </label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="notifications[{{ $notification['key'] }}]"
                                    class="sr-only peer" checked>
                                <div
                                    class="w-11 h-6 bg-zinc-300 dark:bg-zinc-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent">
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
        </s>
    </section>
