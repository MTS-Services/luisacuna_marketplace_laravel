<div>

    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-primary">
                {{ __('User Profile') }}
            </h2>

            <div class="flex items-center gap-2">
                    <x-ui.button
                            x-on:click="$dispatch('show-translation-modal', {
                                modelId: '{{ encrypt($user->id) }}',
                                modelType: '{{ base64_encode(\App\Models\User::class) }}'
                            })"
                            variant="secondary" class="w-auto py-2! text-nowrap">
                            <flux:icon name="arrows-pointing-out"
                                class="w-4 h-4 stroke-text-btn-secondary group-hover:stroke-text-btn-primary" />
                            {{ __('Manage Translations') }}
                        </x-ui.button>
                <x-ui.button href="{{ route('admin.um.user.index') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>
    <div class="rounded-xl p-6 min-h-[500px] flex flex-row gap-5">
        {{-- PERSONAL INFO (Default Tab) --}}
        <div class="w-1/5  gap-6">
            {{-- Left Column --}}
            <div class="flex flex-col h-auto px-4   ">
                <h2 class="text-xl font-semibold mb-6 border-b border-zinc-100 pb-2 text-text-primary">
                    {{ __('Profile Image') }}</h2>
                <div
                    class="w-32 h-32 rounded-full mx-auto mb-6 border-4 border-pink-100 overflow-hidden flex justify-center text-ceneter items-center">
                    @if ($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="Profile Image"
                            class="w-full h-full object-cover">
                    @else
                        <span class="font-bold text-3xl">
                            {{ strtoupper(substr($user->username, 0, 2)) }}
                        </span>
                    @endif
                </div>
                <div class="flex flex-col items-center justify-between mb-8">
                    <h3 class="text-2xl font-bold text-center mb-1 text-text-primary">
                        {{ __('@') }}{{ $user->username }}</h3>
                    <p class="text-text-secondary">{{ $user->email }}</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-1 gap-6 w-full">
                <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                    <p class="text-text-white text-xs font-semibold mb-2">{{ __('FACEBOOK ID') }}</p>
                    <p class="text-slate-400 text-lg font-bold ">{{ $user->facebook_id ?? 'N/A' }}</p>
                </div>
                <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                    <p class="text-text-white text-xs font-semibold mb-2">{{ __('GOOGLE ID') }}</p>
                    <p class="text-slate-400 text-lg font-bold ">{{ $user->google_id ?? 'N/A' }}</p>
                </div>
                <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                    <p class="text-text-white text-xs font-semibold mb-2">{{ __('APPLE ID') }}</p>
                    <p class="text-slate-400 text-lg font-bold ">{{ $user->apple_id ?? 'N/A' }}</p>
                </div>
            </div>

        </div>

        {{-- Right Column --}}
        <div class="w-4/5 col-span-1 lg:col-span-2 ">
            <h2 class="text-xl font-semibold mb-6 border-b border-zinc-100 pb-2 text-text-primary">
                {{ __('Profile Information') }}</h2>

            <div class="bg-bg-primary rounded-2xl shadow-lg overflow-hidden border border-gray-500/20 p-5">

                <!-- Old user Section -->

                <div class="space-y-10">
                    <!-- Info Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 w-full">
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('USERNAME') }}</p>
                            <p class="text-slate-400 text-lg font-bold ">
                                {{ __('@') }}{{ $user->username ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('FIRST NAME') }}</p>
                            <p class="text-slate-400 text-lg font-bold ">{{ $user->first_name ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('LAST NAME') }}</p>
                            <p class="text-slate-400 text-lg font-bold ">{{ $user->last_name ?? 'N/A' }}</p>
                        </div>

                        {{-- others table --}}

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('USER POINTS') }}</p>
                            <p class="text-slate-400 text-lg font-bold ">{{ $user->userPoint->points ?? 0 }}</p>
                        </div>


                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('POINT NOTE') }}</p>
                            <p class="text-slate-400 text-lg font-bold ">{{ $user->userPoint->note ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('CURRENT RANK') }}</p>
                            <p class="text-slate-400 text-lg font-bold ">{{ $user->userRank->rank->name ?? 'N/A' }}
                            </p>
                        </div>


                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('RANK STATUS') }}</p>
                            <p class="text-slate-400 text-lg font-bold ">
                                @if ($user->userRank && $user->userRank->is_active)
                                    <span class="">{{ __('Active') }}</span>
                                @else
                                    <span class="">{{ __('Inactive') }}</span>
                                @endif
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('RANK ACTIVATED AT') }}</p>
                            <p class="text-slate-400 text-lg font-bold ">
                                {{ $user->userRank->activated_at ?? 'N/A' }}
                            </p>
                        </div>
                        {{-- others table --}}


                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('EMAIL') }}</p>
                            <p class="text-slate-400 text-lg font-bold">{{ $user->email ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('DATE OF BIRTH') }}</p>
                            <p class="text-slate-400 text-lg font-bold">{{ $user->date_of_birth ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('TIMEZONE') }}</p>
                            <p class="text-slate-400 text-lg font-bold">{{ $user->timezone ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('Country') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">
                                {{ $user->country_id ? $user->country->name : 'N/A' }}
                            </p>
                        </div>
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('DEFAULT LANGUAGE') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">
                                {{ $user->language_id ? $user->language->name : 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('DEFAULT CURRENCY') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">
                                {{ $user->currency_id ? $user->currency->name : 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('PHONE') }}</p>
                            <p class="text-slate-400 text-lg font-bold">{{ $user->phone ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('PHONE VERIFIED') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $user->phone_verified_at ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('USER TYPE') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $user->user_type ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('ACCOUNT STATUS') }}
                            </p>
                            <span class="text-slate-400 text-lg font-bold {{ $user->account_status->color() }}">
                                {{ $user->account_status->label() ?? 'N/A' }}
                            </span>
                        </div>


                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('LOGIN ATTEMPTS') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $user->login_attempts == 1 ? 'Yes' : 'No' }}
                            </p>
                        </div>


                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('TERMS ACCEPTED') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $user->terms_accepted_at ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('PRIVACY ACCEPTED') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $user->privacy_accepted_at ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('LAST SYNC') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $user->last_synced_at ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('REMEMBER TOKEN') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $user->remember_token ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('EMAIL VERIFIED') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $user->email_verified_at ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('LAST LOGIN AT') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $user->last_login_at ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('LAST LOGIN IP') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $user->last_login_ip ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">
                                {{ __('TWO FACTOR ENABLED') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">
                                {{ $user->two_factor_enabled === 1 ? 'Yes' : 'No' }}
                            </p>
                        </div>


                        {{-- Default Operation Information  --}}
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED BY') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ getAuditorName($user->creater) }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('UPDATED BY') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">
                                {{ getAuditorName($user->updater) ?? 'N/A' }} 
                                {{-- {{ __('N/A') }} --}}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('DELETED BY') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold"></p>
                            {{ $user->deleted_at ? getAuditorName($user->deleter) : 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('RESTORER BY') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold"></p>
                            {{ $user->restored_at ? getAuditorName($user->restorer) : 'N/A' }}
                            </p>
                        </div>

                        {{-- Default Operation Information  --}}
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED AT') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $user->created_at_formatted ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('UPDATED AT') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $user->updated_at_formatted ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('DELETED AT') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $user->deleted_at_formatted ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('RESTORED AT') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $user->restored_at_formatted ?? 'N/A' }}
                            </p>
                        </div>



                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
