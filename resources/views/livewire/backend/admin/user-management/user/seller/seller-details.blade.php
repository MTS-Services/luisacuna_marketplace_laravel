<section>
    {{-- Page Header --}}
    <div class="glass-card rounded-2xl p-4 lg:p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-xl lg:text-2xl font-bold text-text-primary">
                {{ __('Seller Verification Details') }}
            </h2>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.um.user.all-seller') }}" class="w-auto! py-2!">
                    <flux:icon name="arrow-left"
                        class="w-4 h-4 stroke-text-btn-primary group-hover:stroke-text-btn-secondary" />
                    {{ __('Back') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    <div class="max-w-[1600px] mx-auto p-4 lg:p-8 space-y-8 animate-in fade-in duration-700">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Left Sidebar: Seller Identity Card --}}
            <div class="lg:col-span-3 space-y-6">
                <div
                    class="glass-card rounded-[2.5rem] p-8 border border-zinc-200 dark:border-white/10 bg-white/50 dark:bg-zinc-900/30 shadow-2xl relative overflow-hidden">
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-primary-500/10 rounded-full blur-3xl"></div>

                    <div class="relative flex flex-col items-center">
                        <div class="relative group">
                            <div
                                class="w-40 h-40 rounded-[3rem] rotate-3 group-hover:rotate-0 transition-all duration-500 overflow-hidden border-4 border-white dark:border-zinc-800 shadow-2xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                @if ($data->user->avatar)
                                    <img src="{{ auth_storage_url($data->user->avatar) }}"
                                        class="w-full h-full object-cover -rotate-3 group-hover:rotate-0 scale-110 transition-all duration-500"
                                        alt="{{ $data->user->full_name }}">
                                @else
                                    <div
                                        class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-500 to-indigo-600">
                                        <span
                                            class="text-4xl font-black text-white">{{ strtoupper(substr($data->user->first_name, 0, 2)) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-8 text-center space-y-1">
                            <h3 class="text-2xl font-black text-text-primary tracking-tight">
                                {{ $data->user->first_name }} {{ $data->user->last_name }}</h3>
                            <p class="text-primary-600 dark:text-primary-400 font-bold text-sm">
                                {{ $data->user->email }}</p>
                            <p class="text-text-primary text-xs font-medium uppercase tracking-wide">
                                {{ ucfirst($data->user->user_type->value) }}</p>
                        </div>

                        <div class="w-full grid grid-cols-2 gap-3 mt-8">
                            <div
                                class="p-3 rounded-2xl bg-zinc-100/80 dark:bg-white/5 border border-zinc-200 dark:border-white/5 text-center hover:shadow-inner transition-all">
                                <p class="text-[10px] text-text-primary uppercase font-black tracking-tighter">
                                    {{ __('Account') }}</p>
                                <p class="text-xs font-black text-text-primary truncate">
                                    {{ $data->account_type == 0 ? 'Personal' : 'Business' }}</p>
                            </div>
                            <div
                                class="p-3 rounded-2xl bg-zinc-100/80 dark:bg-white/5 border border-zinc-200 dark:border-white/5 text-center hover:shadow-inner transition-all">
                                <p class="text-[10px] text-text-primary uppercase font-black tracking-tighter">
                                    {{ __('Experience') }}</p>
                                <p class="text-xs font-black text-text-primary truncate">
                                    {{ $data->is_experienced_seller == 1 ? 'Experienced' : 'New' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Verification Status --}}
                <div
                    class="glass-card rounded-[2rem] p-6 space-y-4 border border-zinc-200 dark:border-white/5 bg-zinc-50 dark:bg-zinc-900/20 shadow-sm">
                    <h4 class="text-[10px] font-black text-text-primary uppercase tracking-[0.2em] px-2">
                        {{ __('Verification Status') }}</h4>
                    
                    <div
                        class="p-4 rounded-xl bg-white dark:bg-white/5 border border-zinc-100 dark:border-white/5 shadow-sm">
                        <span class="text-xs font-bold text-text-primary">{{ __('Status') }}</span>
                        <div class="flex items-center gap-2 mt-2">
                            <span
                                class="h-2 w-2 rounded-full {{ $data->seller_verified ? 'bg-emerald-500 animate-pulse' : 'bg-amber-500 animate-pulse' }}"></span>
                            <span class="text-sm font-black text-text-primary">
                                {{ $data->seller_verified ? 'Verified' : 'Pending Verification' }}
                            </span>
                        </div>
                    </div>

                    <div
                        class="p-4 rounded-xl bg-primary-50 dark:bg-primary-500/5 border border-primary-100 dark:border-primary-500/10">
                        <p class="text-[10px] font-black text-primary-600 dark:text-primary-500 uppercase mb-1">
                            {{ __('Submitted') }}</p>
                        <p class="text-xs text-zinc-600 dark:text-zinc-300 leading-relaxed">
                            {{ $data->created_at_formatted ?? 'N/A' }}</p>
                    </div>

                    @if($data->seller_verified_at)
                    <div
                        class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-500/5 border border-emerald-100 dark:border-emerald-500/10">
                        <p class="text-[10px] font-black text-emerald-600 dark:text-emerald-500 uppercase mb-1">
                            {{ __('Verified At') }}</p>
                        <p class="text-xs text-zinc-600 dark:text-zinc-300 leading-relaxed">
                            {{ $data->seller_verified_at }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Main Content --}}
            <div class="lg:col-span-9 space-y-8">
                {{-- Personal/Business Information --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div
                        class="md:col-span-2 glass-card rounded-[2.5rem] overflow-hidden border border-zinc-200 dark:border-white/10 shadow-xl bg-white dark:bg-zinc-900/30">
                        <div class="bg-zinc-50 dark:bg-white/5 p-6 border-b border-zinc-100 dark:border-white/5">
                            <h3
                                class="font-black text-text-primary uppercase tracking-widest text-sm flex items-center gap-2">
                                <flux:icon name="identification" class="w-4 h-4 text-primary-500" />
                                {{ $data->account_type == 0 ? __('Personal Information') : __('Business Information') }}
                            </h3>
                        </div>
                        <div class="p-8 grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-8">
                            @php
                                $personalFields = [];
                                if ($data->account_type == 0) {
                                    $personalFields = [
                                        ['label' => 'First Name', 'val' => $data->first_name, 'icon' => 'user'],
                                        ['label' => 'Last Name', 'val' => $data->last_name, 'icon' => 'user'],
                                    ];
                                } else {
                                    $personalFields = [
                                        ['label' => 'Company Name', 'val' => $data->company_name, 'icon' => 'building-office'],
                                        ['label' => 'License Number', 'val' => $data->company_license_number ?? 'N/A', 'icon' => 'document-text'],
                                        ['label' => 'Tax Number', 'val' => $data->company_tax_number ?? 'N/A', 'icon' => 'document-text'],
                                    ];
                                }
                                
                                $personalFields = array_merge($personalFields, [
                                    ['label' => 'Date of Birth', 'val' => \Carbon\Carbon::parse($data->date_of_birth)->format('d M, Y'), 'icon' => 'calendar'],
                                    ['label' => 'Nationality', 'val' => ucfirst($data->nationality ?? 'N/A'), 'icon' => 'flag'],
                                ]);
                            @endphp

                            @foreach ($personalFields as $f)
                                <div class="flex items-start gap-4">
                                    <div class="p-2.5 rounded-xl bg-zinc-100 dark:bg-white/5 text-text-primary">
                                        <flux:icon :name="$f['icon']" class="w-4 h-4" />
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-text-primary uppercase">
                                            {{ __($f['label']) }}</p>
                                        <p class="text-sm font-bold text-text-primary">{{ $f['val'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Services to Sell --}}
                    <div
                        class="glass-card rounded-[2.5rem] p-8 border border-zinc-200 dark:border-white/10 shadow-xl bg-white dark:bg-zinc-900/30">
                        <h3 class="font-black text-text-primary uppercase tracking-widest text-sm mb-6">
                            {{ __('Services to Sell') }}</h3>
                        <div class="space-y-3">
                            @foreach ($data->categories as $category)
                                <div
                                    class="p-3 rounded-xl bg-primary-50 dark:bg-primary-500/10 border border-primary-100 dark:border-primary-500/20">
                                    <p class="text-xs font-bold text-primary-700 dark:text-primary-300">
                                        {{ $category->name }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Address Information --}}
                <div
                    class="glass-card rounded-[2.5rem] overflow-hidden border border-zinc-200 dark:border-white/10 shadow-xl bg-white dark:bg-zinc-900/30">
                    <div class="bg-zinc-50 dark:bg-white/5 p-6 border-b border-zinc-100 dark:border-white/5">
                        <h3
                            class="font-black text-text-primary uppercase tracking-widest text-sm flex items-center gap-2">
                            <flux:icon name="map-pin" class="w-4 h-4 text-primary-500" />
                            {{ __('Address Information') }}
                        </h3>
                    </div>
                    <div class="p-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-x-12 gap-y-8">
                        @php
                            $addressFields = [
                                ['label' => 'Street Address', 'val' => ucfirst($data->street_address), 'icon' => 'home'],
                                ['label' => 'City', 'val' => ucfirst($data->city), 'icon' => 'building-office-2'],
                                ['label' => 'Country', 'val' => ucfirst($data->country), 'icon' => 'globe-alt'],
                                ['label' => 'Postal Code', 'val' => ucfirst($data->postal_code), 'icon' => 'envelope'],
                            ];
                        @endphp

                        @foreach ($addressFields as $f)
                            <div class="flex items-start gap-4">
                                <div class="p-2.5 rounded-xl bg-zinc-100 dark:bg-white/5 text-text-primary">
                                    <flux:icon :name="$f['icon']" class="w-4 h-4" />
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-text-primary uppercase">
                                        {{ __($f['label']) }}</p>
                                    <p class="text-sm font-bold text-text-primary">{{ $f['val'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Documents --}}
                @php 
                    $cloudinaryService = new \App\Services\Cloudinary\CloudinaryService();
                @endphp
                
                <div
                    class="glass-card rounded-[2.5rem] p-8 border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900/30 shadow-xl overflow-hidden relative">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
                        <div class="space-y-6">
                            <h4 class="text-[10px] font-black text-text-primary uppercase tracking-widest">
                                {{ __('Identification Document') }}</h4>
                            <div
                                class="p-5 rounded-[1.5rem] bg-zinc-50 dark:bg-zinc-900/60 border border-zinc-100 dark:border-white/5 shadow-inner">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-white dark:bg-zinc-800 rounded-xl shadow-sm">
                                        <flux:icon name="document-text" class="w-5 h-5 text-primary-500" />
                                    </div>
                                    <div>
                                        @if ($data->identification)
                                            <a href="{{ $cloudinaryService->getUrlFromPublicId($data->identification ?? '') }}"
                                                target="_blank"
                                                class="text-sm font-black text-primary-600 dark:text-primary-400 hover:underline">
                                                {{ __('Download Document') }}
                                            </a>
                                        @else
                                            <p class="text-sm font-black text-text-primary">{{ __('Not Available') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($data->selfie_image)
                            <div class="space-y-6">
                                <h4 class="text-[10px] font-black text-text-primary uppercase tracking-widest">
                                    {{ __('Selfie Image') }}</h4>
                                <div
                                    class="p-5 rounded-[1.5rem] bg-zinc-50 dark:bg-zinc-900/60 border border-zinc-100 dark:border-white/5 shadow-inner">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 bg-white dark:bg-zinc-800 rounded-xl shadow-sm">
                                            <flux:icon name="camera" class="w-5 h-5 text-primary-500" />
                                        </div>
                                        <div>
                                            <a href="{{ $cloudinaryService->getUrlFromPublicId($data->selfie_image ?? '') }}"
                                                target="_blank"
                                                class="text-sm font-black text-primary-600 dark:text-primary-400 hover:underline">
                                                {{ __('View Selfie') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($data->company_documents && $data->account_type == 1)
                            <div class="space-y-6">
                                <h4 class="text-[10px] font-black text-text-primary uppercase tracking-widest">
                                    {{ __('Company Documents') }}</h4>
                                <div
                                    class="p-5 rounded-[1.5rem] bg-zinc-50 dark:bg-zinc-900/60 border border-zinc-100 dark:border-white/5 shadow-inner">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 bg-white dark:bg-zinc-800 rounded-xl shadow-sm">
                                            <flux:icon name="document-duplicate" class="w-5 h-5 text-primary-500" />
                                        </div>
                                        <div>
                                            <a href="{{ $cloudinaryService->getUrlFromPublicId($data->company_documents ?? '') }}"
                                                target="_blank"
                                                class="text-sm font-black text-primary-600 dark:text-primary-400 hover:underline">
                                                {{ __('Download Documents') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-4">
                    @if($data->seller_verified == 1)
                        <x-ui.button wire:click.prevent="makeRejected('{{ encrypt($data->id) }}')"
                            class="w-auto! py-3! px-6!" :variant="'tertiary'">
                            <flux:icon name="x-mark" class="w-4 h-4" />
                            {{ __('Mark as Rejected') }}
                        </x-ui.button>
                    @else
                        <x-ui.button wire:click.prevent="makeVerified('{{ encrypt($data->id) }}')"
                            class="w-auto! py-3! px-6!">
                            <flux:icon name="check" class="w-4 h-4 stroke-white" />
                            {{ __('Mark as Verified') }}
                        </x-ui.button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .glass-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .light .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }
    </style>
</section>