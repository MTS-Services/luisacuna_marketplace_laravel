<section class="min-h-screen bg-bg-primary pb-8">
    <section class=" mx-auto px-0">
        {{-- Header Section --}}
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-text-primary">{{ __('Account Settings') }}</h1>
            {{-- <x-ui.button href="#" class="w-fit! sm:w-auto! py-2!">
                {{ __('Seller API') }}
            </x-ui.button> --}}
        </div>

        <div class=" mx-auto space-y-6">
            {{-- Profile Section --}}
            <section class="sm:bg-bg-secondary rounded-2xl sm:p-15 md:p-20 mb-20">
                <h2 class="text-2xl sm:text-3xl font-semibold text-text-primary mb-8">{{ __('Profile') }}</h2>


                <div
                    class="flex flex-col sm:flex-row items-center justify-center xxs:justify-start bg-bg-info rounded-lg gap-3 sm:gap-6 p-5 mb-6 w-full">
                    <!-- Profile Image -->
                    <div class="relative w-12 h-12 sm:w-20 sm:h-20">
                        <img src="{{ auth_storage_url($existingFile) }}"
                            class="w-full h-full rounded-full object-cover ring-2 ring-purple-400/30" alt="Profile">
                    </div>

                    <!-- Upload Area -->
                    <div class="flex flex-col items-center! xxs:items-start!">
                        <label for="imageUpload"
                            class="bg-zinc-500 text-white hover:bg-bg-white hover:text-zinc-500 text-text-white font-medium py-2 px-4 rounded-full cursor-pointer transition text-sm w-fit">
                            {{ __('Upload image') }}
                        </label>

                        <input id="imageUpload" type="file" class="hidden" name="avatar"
                            accept="image/jpeg,image/png,image/heic" wire:model="avatar">

                        <span class="text-sm text-text-secondary mt-2">
                            {{ __('Must be JPEG, PNG or HEIC and cannot exceed 10MB.') }}
                        </span>

                        @error('avatar')
                            <span class="text-pink-500 text-xs mt-1">{{ $message }}</span>
                        @enderror

                        <div wire:loading wire:target="avatar" class="text-sm text-purple-600 mt-2">
                            {{ __('Uploading...') }}
                        </div>
                    </div>
                </div>





                {{-- Bio Textarea --}}
                {{-- <div class="p-6 bg-bg-info rounded-lg" x-data="{ editMode: false }">
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
                        </div>

                        <!-- Edit Mode -->
                        <div x-show="editMode" x-cloak class="bg-bg-info p-3 sm:p-6 rounded-lg">
                            <div class="relative">
                                <textarea rows="4" wire:model.defer="form.description"
                                    class="w-full border border-zinc-300 bg-bg-info rounded-lg px-4 py-3 text-text-primary placeholder:text-text-muted focus:outline-hidden focus:ring-2 focus:ring-accent resize-none"
                                    placeholder="Write a short bio about yourself..." wire:model="form.description"></textarea>
                            </div>
                        </div>
                        <div class="flex justify-start gap-3 mt-6">
                            <x-ui.button wire:click="updateProfile" @click="editMode = false" class="w-fit! py-2!">
                                {{ __('Save changes') }}
                            </x-ui.button>
                        </div>
                    </div>

                </div> --}}
                <div class="p-6 bg-bg-info rounded-lg" x-data="{ editMode: false }">
                    <div class="flex justify-between items-center gap-6 mb-3">
                        <h2 class="block text-base font-medium text-text-primary">{{ __('Your description') }}</h2>
                        <p class="px-2 py-1.5 sm:px-4 sm:py-3 bg-zinc-50/20 justify-end rounded-lg shrink-0 self-start cursor-pointer hover:bg-zinc-50/30 transition"
                            @click="editMode = true">
                            <x-phosphor name="note-pencil" variant="regular" />
                        </p>
                    </div>

                    <!-- Display Mode -->
                    <div x-show="!editMode" x-cloak>
                        <div class="w-full p-3 bg-zinc-50/20 rounded-lg">
                            {{-- <p class="text-text-white text-xs">{{ user()->description ?? 'Description no abailable' }}
                            </p> --}}
                            <p class="text-text-white text-xs">
                                {{ user()->description ? user()->description : 'Description not available' }}
                            </p>

                        </div>
                    </div>

                    <!-- Edit Mode -->
                    <div x-show="editMode" x-cloak class="bg-bg-info p-3 sm:p-6 rounded-lg mt-3">
                        <textarea rows="4" wire:model.defer="form.description"
                            class="w-full border border-zinc-300 bg-bg-info rounded-lg px-4 py-3 text-text-primary placeholder:text-text-muted focus:outline-hidden focus:ring-2 focus:ring-accent resize-none"
                            placeholder="Write a short bio about yourself..."></textarea>

                        <div class="flex justify-start gap-3 mt-6">
                            <x-ui.button wire:click="updateProfile" @click="editMode = false" class="w-fit! py-2!">
                                {{ __('Save changes') }}
                            </x-ui.button>
                            <button type="button" @click="editMode = false"
                                class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                                {{ __('Cancel') }}
                            </button>
                        </div>
                    </div>
                </div>

                {{-- </form> --}}
            </section>

            {{-- Profile Details Section --}}
            <section class="sm:bg-bg-secondary rounded-2xl  mt-5 sm:p-15 md:p-20 mb-20">
                <h2 class="text-2xl sm:text-3xl font-semibold text-text-white mb-8">{{ __('Personal info') }}</h2>

                <div>
                    <form class="space-y-5">

                        {{-- First Name --}}
                        <div x-data="{
                            editMode: @js($errors->has('form.first_name'))
                        }" @profile-updated.window="editMode = false">
                            <div class="p-3 sm:p-6 bg-bg-info rounded-lg" x-show="!editMode">
                                <h2 class="block text-base font-medium text-text-primary mb-2">{{ __('First name:') }}
                                </h2>
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

                            <div x-show="editMode" x-cloak class="bg-bg-info p-3 sm:p-6 rounded-lg">
                                <label
                                    class="block text-sm font-medium text-text-primary mb-2">{{ __('First name:') }}</label>
                                <div class="relative">
                                    <input type="text" wire:model.blur="form.first_name"
                                        class="w-full bg-bg-secondary border @error('form.first_name') border-red-500 @else border-zinc-300 dark:border-zinc-700 @enderror rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                        placeholder="Enter first name">
                                </div>
                                @error('form.first_name')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror

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
                        <div x-data="{
                            editMode: @js($errors->has('form.last_name'))
                        }" @profile-updated.window="editMode = false">
                            <div class="p-3 sm:p-6 bg-bg-info rounded-lg" x-show="!editMode">
                                <h2 class="block text-base font-medium text-text-primary mb-2">{{ __('Last name:') }}
                                </h2>
                                <div class="flex items-center gap-2 sm:gap-6 w-full">
                                    <div class="w-full p-3 bg-zinc-50/20 rounded-lg">
                                        <p class="text-text-white text-xs">{{ $form->last_name }}</p>
                                    </div>
                                    <div @click="editMode = true"
                                        class="px-2 py-1.5 sm:px-4 sm:py-3 bg-zinc-50/20 rounded-lg shrink-0 self-start cursor-pointer hover:bg-zinc-50/30 transition">
                                        <x-phosphor name="note-pencil" variant="regular" />
                                    </div>
                                </div>
                            </div>

                            <div x-show="editMode" x-cloak class="bg-bg-info p-3 sm:p-6 rounded-lg">
                                <label
                                    class="block text-sm font-medium text-text-primary mb-2">{{ __('Last name:') }}</label>
                                <div class="relative">
                                    <input type="text" wire:model.blur="form.last_name"
                                        class="w-full bg-bg-secondary border @error('form.last_name') border-red-500 @else border-zinc-300 dark:border-zinc-700 @enderror rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                        placeholder="Enter last name">
                                </div>
                                @error('form.last_name')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror

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

                        {{-- Email --}}
                        <div x-data="{
                            editMode: @js($errors->has('form.email'))
                        }" @profile-updated.window="editMode = false">
                            <div class="p-3 sm:p-6 bg-bg-info rounded-lg" x-show="!editMode">
                                <h2 class="block text-base font-medium text-text-primary mb-2">{{ __('Email:') }}
                                </h2>
                                <div class="flex items-center gap-2 sm:gap-6 w-full">
                                    <div class="w-full">
                                        <div class="p-3 bg-zinc-50/20 rounded-lg">
                                            <p class="text-text-white text-xs">{{ $form->email }}</p>
                                        </div>
                                        <div class="mt-2">
                                            <p class="text-text-white text-sm sm:text-xl">
                                                @if (!is_email_verified(user()))
                                                    <span class="text-pink-500">{{ __('Verified') }}</span>
                                                @endif
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

                            <div x-show="editMode" x-cloak class="bg-bg-info p-3 sm:p-6 rounded-lg">
                                <label
                                    class="block text-sm font-medium text-text-primary mb-2">{{ __('Email:') }}</label>
                                <div class="relative">
                                    <input type="email" wire:model.live="form.email"
                                        class="w-full bg-bg-secondary border @error('form.email') border-red-500 @else border-zinc-300 dark:border-zinc-700 @enderror rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                        placeholder="Enter email">
                                </div>
                                @error('form.email')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror

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

                        {{-- Username --}}
                        <div x-data="{
                            editMode: @js($errors->has('form.username'))
                        }" @profile-updated.window="editMode = false">
                            <div class="p-3 sm:p-6 bg-bg-info rounded-lg" x-show="!editMode">
                                <h2 class="block text-base font-medium text-text-primary mb-2">{{ __('Username:') }}
                                </h2>
                                <div class="flex items-center gap-2 sm:gap-6 w-full">
                                    <div class="w-full">
                                        <div class="p-3 bg-zinc-50/20 rounded-lg">
                                            <p class="text-text-white text-xs">{{ $form->username }}</p>
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

                            <div x-show="editMode" x-cloak class="bg-bg-info p-3 sm:p-6 rounded-lg">
                                <label
                                    class="block text-sm font-medium text-text-primary mb-2">{{ __('Username:') }}</label>
                                <div class="relative">
                                    <input type="text" wire:model.live="form.username"
                                        class="w-full bg-bg-secondary border @error('form.username') border-red-500 @else border-zinc-300 dark:border-zinc-700 @enderror rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
                                        placeholder="Enter username">
                                </div>
                                @error('form.username')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror

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

                        {{-- Password --}}
                        <livewire:backend.user.settings.change-password />
                    </form>
                </div>
            </section>

            {{-- Profile Details Section --}}
            <section class="sm:bg-bg-secondary rounded-2xl  mt-5 sm:p-15 md:p-20 mt-20">

                <livewire:backend.user.settings.two-factor-authenticaiton />

                <div class="bg-bg-info p-3 sm:p-6 rounded-lg mt-5">
                    <x-ui.label value="Log out from all sessions"
                        class="block text-sm font-medium text-text-primary mb-2" />
                    <x-ui.button class="w-fit! py-2! my-2!" wire:click="logoutFromAllDevices">
                        <span wire:loading.remove wire:target="logoutFromAllDevices"
                            class="text-text-btn-primary group-hover:text-text-btn-secondary transition-all duration-300">
                            {{ __('Log out from all devices') }}
                        </span>
                        <span wire:loading wire:target="logoutFromAllDevices"
                            class="text-text-btn-primary group-hover:text-text-btn-secondary transition-all duration-300">
                            {{ __('Logging out from all devices...') }}
                        </span>
                    </x-ui.button>
                    <p class="text-sm lg:text-xl font-normal text-text-white">
                        {{ __('This button logs you out from a II devices and browsers.') }}</p>
                    <div class="text-xs flex flex-row gap-1 mt-2">
                        <span class="text-pink-500">*</span>
                        <p class="text-text-white text-xs ">{{ __('This action can take up to 1 hours') }}</p>
                    </div>
                </div>

            </section>

            {{-- Email Notifications Section --}}
            <livewire:backend.user.settings.account-notification />
        </div>
    </section>
