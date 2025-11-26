<section class="min-h-screen bg-bg-secondary py-8">
    <section class=" mx-auto px-4">
        {{-- Header Section --}}
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-text-primary">{{ __('Account Settings') }}</h1>
            <x-ui.button href="{{ route('user.purchased-orders') }}" class="w-fit! sm:w-auto! py-2!">
                {{ __('Seller API') }}
            </x-ui.button>
        </div>
        {{-- All errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-xs !text-red-600 dark:!text-red-400 space-y-1">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class=" mx-auto space-y-6">
            {{-- Profile Section --}}
            <section class="sm:bg-bg-primary rounded-2xl sm:p-15 md:20">
                <h2 class="text-2xl sm:text-3xl font-semibold text-text-primary mb-8">{{ __('Profile') }}</h2>


               

                <div x-data="imageUploader()"
                    class="flex items-center bg-zinc-100 dark:bg-zinc-50/10 rounded-lg gap-6 p-5 mb-6 w-full">

                    <!-- Profile Image -->
                    <div class="relative">
                        <img :src="previewUrl || defaultUrl"
                            class="w-20 h-20 rounded-full object-cover ring-2 ring-purple-400/30" alt="Profile">
                    </div>

                    <!-- Upload Area -->
                    <div class="flex flex-col">
                        <label for="imageUpload"
                            class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-full cursor-pointer transition text-sm w-fit">
                            {{ __('Upload image') }}
                        </label>

                        {{-- <input id="imageUpload" type="file" class="hidden" accept="image/jpeg,image/png,image/heic"
                            wire:model="form.avatar" @change="uploadAndPreview"> --}}
                        <input id="imageUpload" type="file" class="hidden" accept="image/jpeg,image/png,image/heic"
                            wire:model="form.avatar" @change="uploadAndPreview">

                        <span class="text-sm text-text-secondary mt-2">
                            {{ __('Must be JPEG, PNG or HEIC and cannot exceed 10MB.') }}
                        </span>

                        @error('form.avatar')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>



                {{-- Bio Textarea --}}
                <div class="p-6 bg-zinc-100 dark:bg-zinc-50/10 rounded-lg" x-data="{ editMode: false }">
                    <div class="flex justify-between items-center gap-6 mb-3">
                        <h2 class="block text-base font-medium text-text-primary">{{ __('Your description') }}</h2>
                        <p class="px-2 py-1.5 sm:px-4 sm:py-3 bg-zinc-50/20 justify-end rounded-lg shrink-0 self-start cursor-pointer hover:bg-zinc-50/30 transition"
                            @click="editMode = true">
                            <x-phosphor name="note-pencil" variant="regular" />
                        </p>
                    </div>


                    <!-- Display Mode -->
                    <div class="" x-show="!editMode">
                        <div class="w-full p-3 bg-zinc-50/20 rounded-lg">
                            <p class="text-text-white text-xs">{{ user()->description }}</p>
                            {{-- <p class="text-text-white text-xs">
                                {{ __('At PixelStoreLAT, we bring you the best digital deals, game keys, and in-game items — fast, safe, and hassle-free. Trusted by thousands of gamers worldwide with 97% positive reviews. Level up your experience with us today!') }}
                            </p> --}}
                            {{-- <textarea rows="4" class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-3 text-text-primary placeholder:text-text-muted focus:outline-hidden focus:ring-2 focus:ring-accent resize-none">{{ user()->description }}</textarea> --}}
                        </div>
                    </div>

                    <!-- Edit Mode -->
                    <div x-show="editMode" x-cloak>
                        <div class="relative">
                            <textarea rows="4" wire:model.defer="form.description"
                                class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-3 text-text-primary placeholder:text-text-muted focus:outline-hidden focus:ring-2 focus:ring-accent resize-none"
                                placeholder="Write a short bio about yourself..." wire:model="form.description"></textarea>
                        </div>
                    </div>
                    {{-- Action Buttons --}}
                    <div class="flex justify-start gap-3 mt-6">
                        <x-ui.button wire:click="updateProfile" @click="editMode = false" class="w-fit! py-2!">
                            {{ __('Save changes') }}
                        </x-ui.button>
                    </div>
                </div>

                {{-- </form> --}}
            </section>

            {{-- Profile Details Section --}}
            <section class="sm:bg-bg-primary rounded-2xl  mt-5 sm:p-15 md:20">
                <h2 class="text-2xl sm:text-3xl font-semibold text-text-white mb-8">{{ __('Profile') }}</h2>

                <form class="space-y-5">


                    {{-- First Name --}}
                    <div x-data="{ editMode: false }" @profile-updated.window="editMode = false">
                        <div class="p-3 sm:p-6 bg-zinc-100 dark:bg-zinc-50/10 rounded-lg" x-show="!editMode">
                            <h2 class="block text-base font-medium text-text-primary mb-2">{{ __('First name:') }}</h2>
                            <div class="flex items-center gap-2 sm:gap-6 w-full">
                                <div class="w-full p-3 bg-zinc-50/20 rounded-lg">
                                    <p class="text-text-white text-xs">{{ $form->first_name }}</p>
                                </div>
                                <div @click="editMode = true"
                                    class="px-2 py-1.5 sm:px-4 sm:py-3 bg-zinc-50/20 rounded-lg shrink-0 self-start cursor-pointer hover:bg-zinc-50/30 transition">
                                    <x-phosphor name="note-pencil" variant="regular" />
                                </div>
                            </div>
                        </div>
                        @error('form.first_name')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                        <div x-show="editMode" x-cloak>
                            <label
                                class="block text-sm font-medium text-text-primary mb-2">{{ __('First name:') }}</label>
                            <div class="relative">
                                <input type="text" wire:model.defer="form.first_name"
                                    class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                    placeholder="Enter first name">
                                <x-ui.input-error :messages="$errors->get('form.first_name')" />
                                <button type="button"
                                    class="absolute top-1/2 -translate-y-1/2 right-3 text-text-muted hover:text-text-primary">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex justify-start gap-3 mt-4">
                                <x-ui.button wire:click="updateProfile" class="w-fit! py-2!">
                                    {{ __('Save changes') }}
                                </x-ui.button>
                                <button type="button" @click="editMode = false"
                                    class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                                    {{ __('Cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>


                    {{-- Last name --}}
                    <div x-data="{ editMode: false }">
                        <div class="p-3 sm:p-6 bg-zinc-100 dark:bg-zinc-50/10 rounded-lg" x-show="!editMode">
                            <h2 class="block text-base font-medium text-text-primary mb-2">{{ __('Last name:') }}</h2>
                            <div class="flex items-center gap-2 sm:gap-6 w-full">
                                <div class="w-full p-3 bg-zinc-50/20 rounded-lg">
                                    <p class="text-text-white text-xs">{{ user()->last_name }}</p>
                                </div>
                                <div @click="editMode = true"
                                    class="px-2 py-1.5 sm:px-4 sm:py-3 bg-zinc-50/20 rounded-lg shrink-0 self-start cursor-pointer hover:bg-zinc-50/30 transition">
                                    <x-phosphor name="note-pencil" variant="regular" />
                                </div>
                            </div>
                        </div>
                        @error('form.last_name')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror

                        <div x-show="editMode" x-cloak>
                            <label
                                class="block text-sm font-medium text-text-primary mb-2">{{ __('Last name:') }}</label>
                            <div class="relative">
                                <input type="text" name="company" value="{{ user()->last_name }}"
                                    wire:model.defer="form.last_name"
                                    class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                    placeholder="Enter company name">
                                    <x-ui.input-error :messages="$errors->get('form.last_name')" />
                                <button type="button"
                                    class="absolute top-1/2 -translate-y-1/2 right-3 text-text-muted hover:text-text-primary">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex justify-start gap-3 mt-4">
                                <x-ui.button wire:click="updateProfile" @click="editMode = false"
                                    class="w-fit! py-2!">
                                    {{ __('Save changes') }}
                                </x-ui.button>
                                <button type="button" @click="editMode = false"
                                    class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                                    {{ __('Cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div x-data="{ editMode: false }">
                        <div class="p-3 sm:p-6 bg-zinc-100 dark:bg-zinc-50/10 rounded-lg" x-show="!editMode">
                            <h2 class="block text-base font-medium text-text-primary mb-2">{{ __('Email:') }}</h2>
                            <div class="flex items-center gap-2 sm:gap-6 w-full">
                                <div class="w-full">
                                    <div class="p-3 bg-zinc-50/20 rounded-lg">
                                        <p class="text-text-white text-xs">{{ user()->email }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-text-white text-sm sm:text-xl"><span
                                                class="text-pink-500">{{ __('Verified') }}</span>
                                            {{ __('This email is linked to your account. It is not visible to other users.') }}
                                        </p>
                                    </div>
                                </div>
                                <div @click="editMode = true"
                                    class="px-2 py-1.5 sm:px-4 sm:py-3 bg-zinc-50/20 rounded-lg shrink-0 self-start cursor-pointer hover:bg-zinc-50/30 transition">
                                    <x-phosphor name="note-pencil" variant="regular" />
                                </div>
                            </div>
                        </div>
                        @error('form.email')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror

                        <div x-show="editMode" x-cloak>
                            <label
                                class="block text-sm font-medium text-text-primary mb-2">{{ __('Email:') }}</label>
                            <div class="relative">
                                <input type="email" name="email" value="" wire:model.defer="form.email"
                                    class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                    placeholder="Enter email">
                                    <x-ui.input-error :messages="$errors->get('form.email')" />
                                <span
                                    class="absolute top-1/2 -translate-y-1/2 right-3 text-xs text-text-muted bg-bg-primary px-2 py-1 rounded">
                                    {{ __('This field is linked and can only be filled in once for user') }}
                                </span>
                            </div>
                            <div class="flex justify-start gap-3 mt-4">
                                <x-ui.button wire:click="updateProfile" @click="editMode = false"
                                    class="w-fit! py-2!">
                                    {{ __('Save changes') }}
                                </x-ui.button>
                                <button type="button" @click="editMode = false"
                                    class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                                    {{ __('Cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Username --}}
                    <div x-data="{
                        editMode: @error('form.username') true @else false @enderror
                    }">
                        <div class="p-3 sm:p-6 bg-zinc-100 dark:bg-zinc-50/10 rounded-lg" x-show="!editMode">
                            <h2 class="block text-base font-medium text-text-primary mb-2">{{ __('Username:') }}</h2>
                            <div class="flex items-center gap-2 sm:gap-6 w-full">
                                <div class="w-full">
                                    <div class="p-3 bg-zinc-50/20 rounded-lg">
                                        <p class="text-text-white text-xs">{{ user()->username }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-text-white text-sm sm:text-xl">
                                            {{ __('Name that is visible to other "Porkbun" users. You can change your username once every 90 days.') }}
                                        </p>
                                    </div>
                                </div>
                                <div @click="editMode = true"
                                    class="px-2 py-1.5 sm:px-4 sm:py-3 bg-zinc-50/20 rounded-lg shrink-0 self-start cursor-pointer hover:bg-zinc-50/30 transition">
                                    <x-phosphor name="note-pencil" variant="regular" />
                                </div>
                            </div>
                        </div>
                        @error('form.username')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror

                        <div x-show="editMode" x-cloak>
                            <label
                                class="block text-sm font-medium text-text-primary mb-2">{{ __('Username:') }}</label>
                            <div class="relative">
                                <input type="text" name="Username" value="PixelStoreLAT"
                                    wire:model.defer="form.username"
                                    class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                    placeholder="Enter location">
                                    <x-ui.input-error :messages="$errors->get('form.username')" />
                                <button type="button"
                                    class="absolute top-1/2 -translate-y-1/2 right-3 text-text-muted hover:text-text-primary">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex justify-start gap-3 mt-4">
                                <x-ui.button wire:click="updateProfile" @click="editMode = false"
                                    class="w-fit! py-2!">
                                    {{ __('Save changes') }}
                                </x-ui.button>
                                <button type="button" @click="editMode = false"
                                    class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                                    {{ __('Cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div x-data="{ editMode: false }">
                        <div class="p-3 sm:p-6 bg-zinc-100 dark:bg-zinc-50/10 rounded-lg" x-show="!editMode">
                            <h2 class="block text-base font-medium text-text-primary mb-2">{{ __('Password:') }}</h2>
                            <div class="flex items-center gap-2 sm:gap-6 w-full">
                                <div class="w-full">
                                    <div class="p-3 bg-zinc-50/20 rounded-lg">
                                        <p class="text-text-white text-xs">{{ __('********') }}</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-text-white text-sm sm:text-xl">
                                            {{ __('Password can only be changed if you are using the email/password login flow') }}
                                        </p>
                                    </div>
                                </div>
                                <div @click="editMode = true"
                                    class="px-2 py-1.5 sm:px-4 sm:py-3 bg-zinc-50/20 rounded-lg shrink-0 self-start cursor-pointer hover:bg-zinc-50/30 transition">
                                    <x-phosphor name="note-pencil" variant="regular" />
                                </div>
                            </div>
                        </div>

                        <div x-show="editMode" x-cloak>
                            <label
                                class="block text-sm font-medium text-text-primary mb-2">{{ __('Password') }}</label>
                            <div class="relative">
                                <input type="password" value="********" wire:model.defer="form.password"
                                    class="w-full bg-bg-secondary border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                    placeholder="*****">
                                    <x-ui.input-error :messages="$errors->get('form.password')" />
                                <button type="button"
                                    class="absolute top-1/2 -translate-y-1/2 right-3 text-text-muted hover:text-text-primary">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-text-muted mt-1.5">
                                {{ __('You are only e-mails to other. You can type your URL here, and we will redirect them to your personal website or their site') }}
                            </p>
                            <div class="flex justify-start gap-3 mt-4">
                                <x-ui.button wire:click="updateProfile" @click="editMode = false"
                                    class="w-fit! py-2!">
                                    {{ __('Save changes') }}
                                </x-ui.button>
                                <button type="button" @click="editMode = false"
                                    class="px-6 py-3 bg-zinc-200/50 text-text-white rounded-lg hover:bg-gray-700 transition">
                                    {{ __('Cancel') }}
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </section>

            {{-- Email Notifications Section --}}
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

                    @foreach ($notifications as $notification)
                        <div
                            class="flex items-center justify-between py-3  border-zinc-200 dark:border-zinc-800 last:border-b-0">
                            <label class="text-xl text-text-white cursor-pointer flex-1">
                                {{ $notification['label'] }}
                                <span
                                    class="text-sm text-text-muted justify-start block">{{ $notification['sub_title'] }}</span>
                            </label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="notifications[{{ $notification['key'] }}]"
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-zinc-200/80 dark:bg-zinc-200/50 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-accent rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent">
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>


        <script>
            function imageUploader() {
                return {
                    defaultUrl: "{{ storage_url(user()->avatar) ?? asset('assets/images/user_profile/Ellipse 474.png') }}",
                    previewUrl: null,

                    uploadAndPreview(event) {
                        const file = event.target.files[0];
                        if (!file) return;

                        if (file.size > 10 * 1024 * 1024) {
                            alert('File size cannot exceed 10MB.');
                            event.target.value = '';
                            return;
                        }

                        // Preview Image
                        const reader = new FileReader();
                        reader.onload = (e) => this.previewUrl = e.target.result;
                        reader.readAsDataURL(file);

                        // Livewire automatic upload (wire:model triggers updatedFormAvatar)
                    }
                }
            }
        </script>
