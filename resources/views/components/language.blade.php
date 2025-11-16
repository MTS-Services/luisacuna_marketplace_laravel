<div x-data="{ open: false }" class="relative z-40 hover:scale-105 transition-transform duration-200">
    <!-- Trigger Button -->
    <button @click="open = !open" class="flex items-center gap-1 text-text-white hover:text-black">
        <x-phosphor-globe class="w-5 h-5" />
        <span>
            {{ strtoupper(session('locale', 'en')) == 'EN' ? 'En' : 'Fr' }} | 
            {{ session('currency', 'USD-$') }}
        </span>
        <x-phosphor-caret-down class="w-4 h-4" />
    </button>

    <!-- Dropdown Modal -->
    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95" class="absolute z-50 mt-2 right-16 w-80 origin-top-right">
        <div x-transition
             class="dark:bg-zinc-700 bg-bg-primary rounded-2xl shadow-xl w-98 p-6 relative">
            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold flex gap-2 items-center text-text-white">
                    <x-phosphor-globe class="w-6 h-6" /> Choose your language & currency
                </h2>
                <button @click="open = false">
                    <x-phosphor-x class="w-5 h-5 text-gray-500 hover:text-text-white" />
                </button>
            </div>

            <!-- Form -->
            {{-- <form method="POST" action="{{ route('lang.change') }}">
                @csrf
                <div class="space-y-4">
                    <!-- Language -->
                    <div>
                        <x-ui.label class="mb-1!">Language</x-ui.label>
                        <x-ui.select name="lang" class="text-text-white!">
                            <option value="en" {{ session('locale', 'en') == 'en' ? 'selected' : '' }}>{{ __('English (EN)') }}</option>
                            <option value="fr" {{ session('locale', 'en') == 'fr' ? 'selected' : '' }}>{{ __('Français (FR)') }}</option>
                            <option value="de" {{ session('locale', 'en') == 'de' ? 'selected' : '' }}>{{ __('Deutsch (DE)') }}</option>
                            <option value="es" {{ session('locale', 'en') == 'es' ? 'selected' : '' }}>{{ __('Español (ES)') }}</option>
                            <option value="jp" {{ session('locale', 'en') == 'jp' ? 'selected' : '' }}>{{ __('日本語 (JP)') }}</option>
                            <option value="it" {{ session('locale', 'en') == 'it' ? 'selected' : '' }}>{{ __('Italiano (IT)') }}</option>
                            <option value="id" {{ session('locale', 'en') == 'id' ? 'selected' : '' }}>{{ __('Bahasa Indonesia (ID)') }}</option>
                            <option value="br" {{ session('locale', 'en') == 'br' ? 'selected' : '' }}>{{ __('Português (BR)') }}</option>
                        </x-ui.select>
                    </div>

                    <!-- Currency Selection (Only EUR for french) -->
                    <div>
                        <x-ui.label class="mb-1!">Currency</x-ui.label>
                        <x-ui.select name="currency" class="text-text-white!">
                            <option value="USD-$" selected>USD-$</option>
                            <option value="EUR-€" selected>EUR-€</option>
                        </x-ui.select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col gap-2 mt-4">
                        <x-ui.button type="submit"
                            class="w-auto! py-2! rounded-lg! ">
                            Save
                        </x-ui.button>
                    </div>
                    <div class="flex flex-col gap-2 mt-4">
                        <x-ui.button  @click="open = false" variant="secondary"
                            class="w-auto! py-2! rounded-lg!">
                            Close
                        </x-ui.button>
                    </div>
                </div>
            </form> --}}
            <x-language-switcher />
        </div>
    </div>
</div>