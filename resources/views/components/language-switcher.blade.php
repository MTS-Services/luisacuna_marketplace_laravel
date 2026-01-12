@props(['currencies' => []])
<form method="POST" action="{{ route('lang.change') }}">
    @csrf
    <div class="space-y-4">
        <div>
            <x-ui.label class="mb-1!">{{ __('Language') }}</x-ui.label>
            <x-ui.select name="lang" class="text-text-white!">
                @foreach ($languages as $language)
                    <option value="{{ $language->locale }}"
                        {{ session('locale', app()->getLocale()) == $language->locale ? 'selected' : '' }}>
                        {{ $language->native_name }} ({{ strtoupper($language->locale) }})
                    </option>
                @endforeach
            </x-ui.select>
        </div>

        <div>
            <x-ui.label class="mb-1!">{{ __('Currency') }}</x-ui.label>
            <x-ui.select name="currency" class="text-text-white!">
                @forelse ($currencies as $currency)
                    <option value="{{ $currency->code }}"
                        {{ session('currency', 'USD') == $currency->code ? 'selected' : '' }}>
                        {{ $currency->code }} - {{ $currency->symbol }}
                    </option>
                @empty
                    <option value="USD">USD - $</option>
                @endforelse
            </x-ui.select>
        </div>

        <div class="flex flex-col gap-2 mt-4">
            <x-ui.button type="submit" class="w-auto! py-2! rounded-lg! ">
                {{ __('Save') }}
            </x-ui.button>
        </div>
        <div class="flex flex-col gap-2 mt-4">
            <x-ui.button @click="open = false" variant="secondary" class="w-auto! py-2! rounded-lg!">
                {{ __('Close') }}
            </x-ui.button>
        </div>
    </div>
</form>
