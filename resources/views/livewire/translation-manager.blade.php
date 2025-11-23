<div class="p-6 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Translation Manager</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if ($usage)
        <div class="bg-blue-50 border border-blue-200 rounded p-4 mb-4">
            <p class="text-sm">
                <strong>API Usage:</strong>
                {{ number_format($usage['character_count']) }} / {{ number_format($usage['character_limit']) }}
                characters
                ({{ $usage['usage_percentage'] }}%)
            </p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium mb-2">Source Language (Optional)</label>
            <input type="text" wire:model="sourceLanguage" placeholder="e.g., EN (auto-detect if empty)"
                class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Target Language *</label>
            <select wire:model="targetLanguage" class="w-full border rounded px-3 py-2">
                <option value="">Select Language</option>
                @foreach ($targetLanguages as $lang)
                    <option value="{{ $lang['code'] }}">{{ $lang['name'] }} ({{ $lang['code'] }})</option>
                @endforeach
            </select>
            @error('targetLanguage')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="flex gap-4">
        <button wire:click="translate" wire:loading.attr="disabled"
            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded disabled:opacity-50">
            <span wire:loading.remove wire:target="translate">Translate</span>
            <span wire:loading wire:target="translate">Translating...</span>
        </button>
    </div>

    @if (count($translatedData) > 0)
        <div class="mt-6">
            <h3 class="text-xl font-semibold mb-3">Translated Content</h3>

            @foreach ($translatedData as $key => $value)
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">{{ ucfirst($key) }}</label>
                    <textarea wire:model="translatedData.{{ $key }}" rows="3" class="w-full border rounded px-3 py-2">{{ $value }}</textarea>
                </div>
            @endforeach

            <button wire:click="saveTranslation" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded">
                Save Translation
            </button>
        </div>
    @endif
</div>
