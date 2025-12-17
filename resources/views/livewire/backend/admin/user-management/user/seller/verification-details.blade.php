<section>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-black dark:text-text-white">
                {{ __('Seller Verification Details') }}
            </h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.um.user.seller-verification') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left" class="w-4 h-4 stroke-white" />
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
                    class="w-32 h-32 rounded-full mx-auto mb-6 border-4 border-pink-100 overflow-hidden flex justify-center text-center items-center">
                    @if ($data->user->avatar)
                        <img src="{{ storage_url($data->user->avatar) }}" alt="Profile Image"
                            class="w-full h-full object-cover">
                    @else
                        <span class="font-bold text-3xl">
                            {{ strtoupper(substr($data->user->first_name, 0, 2)) }}
                        </span>
                    @endif
                </div>
                <div class="flex flex-col items-center justify-between mb-8">
                    <h3 class="text-2xl font-bold text-center mb-1 text-text-primary">{{ $data->user->first_name }}</h3>
                    <p class="text-text-secondary">{{ $data->user->email }}</p>
                    <div class="flex flex-row items-center justify-between">
                        <p class="text-text-secondary mr-2">{{ __('User Type: ') }}</p>
                        <p class="text-text-secondary"> {{ ucfirst($data->user->user_type->value) }}</p>
                    </div>
                </div>
            </div>
            {{-- <div class="grid grid-cols-1 sm:grid-cols-1 gap-6 w-full">
                <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                    <p class="text-text-white text-xs font-semibold mb-2">{{ __('Account Type') }}</p>
                    <p class="text-slate-400 text-lg font-bold ">{{ $data->account_type }}</p>
                </div>
            </div> --}}

        </div>

        {{-- Right Column --}}
        <div class="w-4/5 col-span-1 lg:col-span-2 ">
            <h2 class="text-xl font-semibold mb-6 border-b border-zinc-100 pb-2 text-text-primary">
                {{ __('Profile Information') }}</h2>

            <div class="bg-bg-primary rounded-2xl shadow-lg overflow-hidden border border-gray-500/20 p-5">

                <!-- Old Data Section -->

                <div class="space-y-10">
                    <!-- Info Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 w-full">
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('ACCOUNT TYPE') }}</p>
                            <p class="text-slate-400 text-lg font-bold ">
                                {{ $data->account_type == 0 ? 'Personal' : 'Business' }}</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('EXPERIENCE') }}</p>
                            <p class="text-slate-400 text-lg font-bold ">
                                {{ $data->is_experienced_seller == 1 ? 'Experienced' : 'New' }}</p>
                        </div>
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('VERIFIED STATUS') }}</p>
                            <p class="text-slate-400 text-lg font-bold ">
                                {{ $data->seller_verified == 1 ? 'Verified' : 'Unverified' }}</p>
                        </div>
                        @if ($data->account_type == 0)
                            <div
                                class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('FIRST NAME') }}</p>
                                <p class="text-slate-400 text-lg font-bold ">{{ $data->first_name }}</p>
                            </div>
                            <div
                                class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('LAST NAME') }}</p>
                                <p class="text-slate-400 text-lg font-bold ">{{ $data->last_name }}</p>
                            </div>
                        @else
                            <div
                                class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('COMPANY NAME') }}</p>
                                <p class="text-slate-400 text-lg font-bold ">{{ $data->company_name }}</p>
                            </div>
                        @endif

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('DATE OF BIRTH') }}</p>
                            <p class="text-slate-400 text-lg font-bold">
                                {{ \Carbon\Carbon::parse($data->date_of_birth)->format('d M, Y') }}
                            </p>
                        </div>
                        @if ($data->nationality)
                            <div
                                class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('NATIONALITY') }}</p>
                                <p class="text-slate-400 text-lg font-bold">
                                    {{ ucfirst($data->nationality) }}
                                </p>
                            </div>
                        @endif
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('STREET ADDRESS') }}</p>
                            <p class="text-slate-400 text-lg font-bold">
                                {{ ucfirst($data->street_address) }}
                            </p>
                        </div>
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('CITY ') }}</p>
                            <p class="text-slate-400 text-lg font-bold">
                                {{ ucfirst($data->city) }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('COUNTRY') }}</p>
                            <p class="text-slate-400 text-lg font-bold">
                                {{ ucfirst($data->country->name) }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('POSTAL CODE') }}</p>
                            <p class="text-slate-400 text-lg font-bold">
                                {{ ucfirst($data->postal_code) }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('SERVICE TO SELL') }}</p>
                            @foreach ($data->categories as $category)
                                <span
                                    class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-2">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>

                        @if ($data->account_type == 1)
                            <div
                                class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                <p class="text-text-white text-xs font-semibold mb-2">
                                    {{ __('COMPANY LICENSE NUMBER') }}</p>
                                <span
                                    class="text-slate-400 text-lg font-bold">{{ $data->company_license_number }}</span>
                            </div>
                            <div
                                class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('COMPANY TAX NUMBER') }}
                                </p>
                                <span
                                    class="text-slate-400 text-lg font-bold">{{ $data->company_tax_number }}</span>
                            </div>
                        @endif

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('IDENTIFICATION DOCUMENT') }}</p>
                            @if ($data->identification)
                                <a href="{{ storage_url($data->identification) }}" target="_blank"
                                    class="text-blue-600 underline">
                                    {{ __('Download') }}
                                </a>
                            @else
                                <span class="text-slate-400 text-lg font-bold ">N/A</span>
                            @endif
                        </div>
                        @if ($data->selfie_image)
                            <div
                                class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('SELFIE IMAGE') }}</p>
                                @if ($data->selfie_image)
                                    <a href="{{ storage_url($data->selfie_image) }}" target="_blank"
                                        class="text-blue-600 underline">
                                        {{ __('Download') }}
                                    </a>
                                @else
                                    <span class="text-slate-400 text-lg font-bold ">N/A</span>
                                @endif
                            </div>
                        @else
                            <div
                                class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md ">
                                <p class="text-text-white text-xs font-semibold mb-2">{{ __('COMPANY DOCUMENT') }}</p>
                                @if ($data->company_documents)
                                    <a href="{{ storage_url($data->company_documents) }}" target="_blank"
                                        class="text-blue-600 underline">
                                        {{ __('Download') }}
                                    </a>
                                @else
                                    <span class="text-slate-400 text-lg font-bold ">N/A</span>
                                @endif
                            </div>
                        @endif


                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('SUBMITED AT') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $data->created_at_formatted ?? "N/A" }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('VERIFIED AT') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $data->seller_verified_at ?? "N/A" }}
                            </p>
                        </div>

                        {{-- Default Operation Information  --}}

                        {{-- <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED BY') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $data->creater_admin?->name ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('UPDATED BY') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $data->updater_admin?->name ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('DELETED BY') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $data->deleter_admin?->name ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('RESTORER BY') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $data->restorer_admin?->name ?? 'N/A' }}
                            </p>
                        </div>

                        
                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('CREATED AT') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $data->created_at_formatted ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('UPDATED AT') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $data->updated_at_formatted ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('DELETED AT') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $data->deleted_at_formatted ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-slate-50 dark:bg-gray-700 rounded-2xl p-6 border border-slate-200 shadow-md">
                            <p class="text-text-white text-xs font-semibold mb-2">{{ __('RESTORED AT') }}
                            </p>
                            <p class="text-slate-400 text-lg font-bold">{{ $data->restored_at_formatted ?? 'N/A' }}
                            </p>
                        </div> --}}

                    </div>
                </div>

            </div>
        </div>
    </div>


</section>