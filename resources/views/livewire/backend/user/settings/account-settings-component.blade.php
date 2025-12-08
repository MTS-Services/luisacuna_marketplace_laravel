<section class="min-h-screen bg-bg-primary py-8">
    <section class=" mx-auto px-4">
        {{-- Header Section --}}
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-text-primary">{{ __('Account Settings') }}</h1>
            <x-ui.button href="#" class="w-fit! sm:w-auto! py-2!">
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
            <section class="sm:bg-bg-secondary rounded-2xl sm:p-15 md:20">
                <h2 class="text-2xl sm:text-3xl font-semibold text-text-primary mb-8">{{ __('Profile') }}</h2>


                <div class="flex items-start sm:items-center bg-bg-info rounded-lg gap-3 sm:gap-6 p-5 mb-6 w-full">
                    <!-- Profile Image -->
                    <div class="relative w-12 h-12 sm:w-20 sm:h-20">
                        <img src="{{ storage_url($existingFile) }}"
                            class="w-full h-full rounded-full object-cover ring-2 ring-purple-400/30" alt="Profile">
                    </div>

                    <!-- Upload Area -->
                    <div class="flex flex-col">
                        <label for="imageUpload"
                            class="bg-purple-600 hover:bg-purple-700 text-text-white font-medium py-2 px-4 rounded-full cursor-pointer transition text-sm w-fit">
                            {{ __('Upload image') }}
                        </label>

                        <input id="imageUpload" type="file" class="hidden" name="avatar"
                            accept="image/jpeg,image/png,image/heic" wire:model="avatar">

                        <span class="text-sm text-text-secondary mt-2">
                            {{ __('Must be JPEG, PNG or HEIC and cannot exceed 10MB.') }}
                        </span>

                        @error('avatar')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror

                        <div wire:loading wire:target="avatar" class="text-sm text-purple-600 mt-2">
                            {{ __('Uploading...') }}
                        </div>
                    </div>
                </div>




                {{-- Bio Textarea --}}
                <div class="p-6 bg-bg-info rounded-lg" x-data="{ editMode: false }">
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
                    <div x-show="editMode" x-cloak class="bg-bg-info p-3 sm:p-6 rounded-lg">
                        <div class="relative">
                            <textarea rows="4" wire:model.defer="form.description"
                                class="w-full border border-zinc-300 bg-bg-info rounded-lg px-4 py-3 text-text-primary placeholder:text-text-muted focus:outline-hidden focus:ring-2 focus:ring-accent resize-none"
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
            <section class="sm:bg-bg-secondary rounded-2xl  mt-5 sm:p-15 md:20">
                <h2 class="text-2xl sm:text-3xl font-semibold text-text-white mb-8">{{ __('Profile') }}</h2>

                <form class="space-y-5">


                    {{-- First Name --}}
                    <div x-data="{ editMode: false }" @profile-updated.window="editMode = false">
                        <div class="p-3 sm:p-6 bg-bg-info rounded-lg" x-show="!editMode">
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
                        <div x-show="editMode" x-cloak class="bg-bg-info p-3 sm:p-6 rounded-lg">
                            <label
                                class="block text-sm font-medium text-text-primary mb-2">{{ __('First name:') }}</label>
                            <div class="relative">
                                <input type="text" wire:model.defer="form.first_name"
                                    class="w-full bg-bg-info border border-zinc-300 dark:border-zinc-700 rounded-lg px-4 py-2.5 text-text-primary focus:outline-hidden focus:ring-2 focus:ring-accent"
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
                        <div class="p-3 sm:p-6 bg-bg-info rounded-lg" x-show="!editMode">
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

                        <div x-show="editMode" x-cloak class="bg-bg-info p-3 sm:p-6 rounded-lg">
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
                        <div class="p-3 sm:p-6 bg-bg-info rounded-lg" x-show="!editMode">
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

                        <div x-show="editMode" x-cloak class="bg-bg-info p-3 sm:p-6 rounded-lg">
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
                        <div class="p-3 sm:p-6 bg-bg-info rounded-lg" x-show="!editMode">
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

                        <div x-show="editMode" x-cloak class="bg-bg-info p-3 sm:p-6 rounded-lg">
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
                    <div>
                        <div class="p-3 sm:p-6 bg-bg-info rounded-lg">
                            <h2 class="block text-base font-medium text-text-primary mb-2">{{ __('Password:') }}</h2>
                            <div class="flex items-center gap-2 sm:gap-6 w-full">
                                <div class="w-full">

                                    <x-ui.button wire:click="openModal" class="w-fit! py-2!">
                                        {{ __('Change password') }}
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="bg-bg-secondary rounded-xl p-6 w-full max-w-md">
                        <div class="space-y-4">
                            <div class="w-full">
                                <x-ui.label value="Old password:"
                                    class="text-base! font-semibold! mb-3! text-text-white!" />
                                <x-ui.input type="password" placeholder="Password Confirmation"
                                    wire:model="form.password_confirmation" />
                                <x-ui.input-error :messages="$errors->get('form.password_confirmation')" />
                            </div>
                            <div class="w-full">
                                <x-ui.label value="New password:"
                                    class="text-base! font-semibold! mb-3! text-text-white!" />
                                <x-ui.input type="password" placeholder="Password Confirmation"
                                    wire:model="form.password_confirmation" />
                                <x-ui.input-error :messages="$errors->get('form.password_confirmation')" />
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <x-phosphor name="x" variant="regular" class="w-4 h-4" />
                                    <p class="text-text-white text-xs font-normal">
                                        {{ __('Password must contain a lowercase letter') }}</p>
                                </div>
                                <div class="flex items-center gap-2 mt-2">
                                    <x-phosphor name="x" variant="regular" class="w-4 h-4" />
                                    <p class="text-text-white text-xs font-normal">
                                        {{ __('Password must contain an uppercase letter') }}</p>
                                </div>
                                <div class="flex items-center gap-2 mt-2">
                                    <x-phosphor name="x" variant="regular" class="w-4 h-4" />
                                    <p class="text-text-white text-xs font-normal">
                                        {{ __('Password must contain a number') }}</p>
                                </div>
                                <div class="flex items-center gap-2 mt-2">
                                    <x-phosphor name="x" variant="regular" class="w-4 h-4" />
                                    <p class="text-text-white text-xs font-normal">
                                        {{ __('Password must be at least 8 characters long') }}</p>
                                </div>
                                <div class="flex items-center gap-2 mt-2">
                                    <x-phosphor name="x" variant="regular" class="w-4 h-4" />
                                    <p class="text-text-white text-xs font-normal">
                                        {{ __('Password must not contain leading or trailing spaces') }}</p>
                                </div>
                            </div>
                            <div class="w-full">
                                <x-ui.label value="Re-enter new password:"
                                    class="text-base! font-semibold! mb-3! text-text-white!" />
                                <x-ui.input type="password" placeholder="Password Confirmation"
                                    wire:model="form.password_confirmation" />
                                <x-ui.input-error :messages="$errors->get('form.password_confirmation')" />
                            </div>

                            <div class="flex items-center justify-end gap-4 mt-6">
                                <x-ui.button wire:click="openModal" class="w-fit! py-2!">
                                    {{ __('Change password') }}
                                </x-ui.button>

                                <x-ui.button class="w-auto! py-2!" type="submit">
                                    <span wire:loading.remove wire:target="save"
                                        class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Cancel ') }}</span>
                                </x-ui.button>
                            </div>
                        </div>
                    </div> --}}
                    @if ($showModal)
                        <div class="fixed inset-0 dark:bg-bg-primary bg-black/50 flex items-center justify-center z-50">
                           <div class="dark:bg-bg-secondary bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 w-full max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl">
                                <div class="space-y-6">
                                    <div class="w-full">
                                        <x-ui.label value="Old password:"
                                            class="text-base! font-semibold! mb-3! text-text-white!" />
                                        <x-ui.input type="password" placeholder="Password Confirmation"
                                            wire:model="form.password_confirmation" />
                                        <x-ui.input-error :messages="$errors->get('form.password_confirmation')" />
                                    </div>
                                    <div class="w-full">
                                        <x-ui.label value="New password:"
                                            class="text-base! font-semibold! mb-3! text-text-white!" />
                                        <x-ui.input type="password" placeholder="Password Confirmation"
                                            wire:model="form.password_confirmation" />
                                        <x-ui.input-error :messages="$errors->get('form.password_confirmation')" />
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <x-phosphor name="x" variant="regular" class="w-4 h-4" />
                                            <p class="text-text-white text-xs font-normal">
                                                {{ __('Password must contain a lowercase letter') }}</p>
                                        </div>
                                        <div class="flex items-center gap-2 mt-2">
                                            <x-phosphor name="x" variant="regular" class="w-4 h-4" />
                                            <p class="text-text-white text-xs font-normal">
                                                {{ __('Password must contain an uppercase letter') }}</p>
                                        </div>
                                        <div class="flex items-center gap-2 mt-2">
                                            <x-phosphor name="x" variant="regular" class="w-4 h-4" />
                                            <p class="text-text-white text-xs font-normal">
                                                {{ __('Password must contain a number') }}</p>
                                        </div>
                                        <div class="flex items-center gap-2 mt-2">
                                            <x-phosphor name="x" variant="regular" class="w-4 h-4" />
                                            <p class="text-text-white text-xs font-normal">
                                                {{ __('Password must be at least 8 characters long') }}</p>
                                        </div>
                                        <div class="flex items-center gap-2 mt-2">
                                            <x-phosphor name="x" variant="regular" class="w-4 h-4" />
                                            <p class="text-text-white text-xs font-normal">
                                                {{ __('Password must not contain leading or trailing spaces') }}</p>
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <x-ui.label value="Re-enter new password:"
                                            class="text-base! font-semibold! mb-3! text-text-white!" />
                                        <x-ui.input type="password" placeholder="Password Confirmation"
                                            wire:model="form.password_confirmation" />
                                        <x-ui.input-error :messages="$errors->get('form.password_confirmation')" />
                                    </div>

                                    <div class="flex items-center justify-end gap-4 mt-6">
                                        <x-ui.button wire:click="openModal" class="w-fit! py-2!">
                                            {{ __('Change password') }}
                                        </x-ui.button>

                                        <x-ui.button class="w-auto! py-2!" type="submit">
                                            <span wire="closeModal"
                                                class="text-text-btn-primary group-hover:text-text-btn-secondary">{{ __('Cancel ') }}</span>
                                        </x-ui.button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </form>
            </section>

            {{-- Email Notifications Section --}}
            <livewire:backend.user.settings.account-notification />
        </div>
