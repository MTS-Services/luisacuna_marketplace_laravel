    <form method="POST" action="{{ route('lang.change') }}">
        @csrf
        <div class="space-y-4">
            <!-- Language -->
            <div>
                <x-ui.label class="mb-1!">Language</x-ui.label>
                <x-ui.select name="lang" class="text-text-white!">                    
                    {{-- <option value="en" {{ session('locale', 'en') == 'en' ? 'selected' : '' }}>
                        {{ __('English (EN)') }}</option>
                    <option value="fr" {{ session('locale', 'en') == 'fr' ? 'selected' : '' }}>
                        {{ __('Français (FR)') }}</option>
                    <option value="de" {{ session('locale', 'en') == 'de' ? 'selected' : '' }}>
                        {{ __('Deutsch (DE)') }}</option>
                    <option value="es" {{ session('locale', 'en') == 'es' ? 'selected' : '' }}>
                        {{ __('Español (ES)') }}</option>
                    <option value="jp" {{ session('locale', 'en') == 'jp' ? 'selected' : '' }}>{{ __('日本語 (JP)') }}
                    </option>
                    <option value="it" {{ session('locale', 'en') == 'it' ? 'selected' : '' }}>
                        {{ __('Italiano (IT)') }}</option>
                    <option value="id" {{ session('locale', 'en') == 'id' ? 'selected' : '' }}>
                        {{ __('Bahasa Indonesia (ID)') }}</option>
                    <option value="br" {{ session('locale', 'en') == 'br' ? 'selected' : '' }}>
                        {{ __('Português (BR)') }}</option> --}}
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
                <x-ui.button type="submit" class="w-auto! py-2! rounded-lg! ">
                    Save
                </x-ui.button>
            </div>
            <div class="flex flex-col gap-2 mt-4">
                <x-ui.button @click="open = false" variant="secondary" class="w-auto! py-2! rounded-lg!">
                    Close
                </x-ui.button>
            </div>
        </div>
    </form>
