<?php

namespace App\Livewire\Backend\Admin;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Language;
use App\Enums\LanguageStatus;
use Illuminate\Support\Facades\Log;

class TranslationManager extends Component
{
    public bool $showTranslationDetailsModal = false;
    public array $languages = [];
    public array $allActiveLanguages = [];
    public string $selectedLanguage = 'all';
    public ?string $modelType = null;
    public ?string $modelId = null;
    public array $translationConfig = [];

    // Track editing states
    public array $editingStates = [];
    public array $editingValues = [];

    public function render()
    {
        return view('livewire.backend.admin.translation-manager', [
            'filteredLanguages' => $this->filteredLanguages(),
            'availableLanguages' => $this->allActiveLanguages,
        ]);
    }

    #[On('show-translation-modal')]
    public function showTranslationDetailsModal($modelId, $modelType)
    {
        // Prevent duplicate calls by checking if already open
        if ($this->showTranslationDetailsModal) {
            return;
        }

        $this->showTranslationDetailsModal = true;
        $this->modelType = base64_decode($modelType);
        $this->modelId = decrypt($modelId);

        // Fetch ALL active languages ONCE (single query) with country_code
        $activeLanguages = Language::where('status', LanguageStatus::ACTIVE)
            ->orderBy('sort_order')
            ->get();

        // Store languages with their country codes for flag display
        $this->allActiveLanguages = $activeLanguages->map(function ($language) {
            return [
                'locale' => $language->locale,
                'country_code' => $language->country_code ?? strtolower($language->locale),
            ];
        })->toArray();

        // Create a language lookup map to avoid additional queries
        $languageMap = $activeLanguages->keyBy('id');

        // Fetch model with all translations eagerly loaded (single query)
        $model = $this->modelType::with([
            $this->getTranslationRelationFromModel()
        ])->findOrFail($this->modelId);

        // Store translation config
        $this->translationConfig = $model->getTranslationConfig();  

        // Get existing translations WITHOUT triggering additional queries
        $existingTranslations = $this->getTranslatedFieldsOptimized($model, $languageMap);

        // Merge with ALL active languages to show empty cards
        $this->languages = $this->mergeWithAllLanguages($existingTranslations);

        // Reset editing states
        $this->editingStates = [];
        $this->editingValues = [];
    }

    /**
     * Get translated fields without N+1 queries
     * Uses already loaded relationships
     */
    private function getTranslatedFieldsOptimized($model, $languageMap): array
    {
        $config = $this->translationConfig;
        $relation = $config['relation'];
        $fieldMapping = $config['field_mapping'];

        $result = [];

        // Initialize arrays for each translatable field
        foreach ($config['fields'] as $field) {
            $result[$field] = [];
        }

        // Loop through already loaded translations (no additional queries)
        foreach ($model->$relation as $translation) {
            $language = $languageMap->get($translation->language_id);

            if ($language) {
                $locale = $language->locale;

                // Map each field
                foreach ($config['fields'] as $field) {
                    $mappedField = $fieldMapping[$field] ?? $field;
                    $result[$field][$locale] = $translation->$mappedField ?? '';
                }
            }
        }

        return $result;
    }

    /**
     * Merge existing translations with all active languages
     * This ensures we show cards for all languages, even without translations
     */
    private function mergeWithAllLanguages(array $existingTranslations): array
    {
        $merged = [];

        foreach ($existingTranslations as $field => $translations) {
            $merged[$field] = [];

            // Add all active languages
            foreach ($this->allActiveLanguages as $langData) {
                $locale = $langData['locale'];
                // Use existing translation or empty string
                $merged[$field][$locale] = $translations[$locale] ?? '';
            }
        }

        return $merged;
    }

    public function filteredLanguages(): array
    {
        if ($this->selectedLanguage === 'all') {
            return $this->languages;
        }

        $filtered = [];
        foreach ($this->languages as $field => $translations) {
            $filtered[$field] = [
                $this->selectedLanguage => $translations[$this->selectedLanguage] ?? '',
            ];
        }

        return $filtered;
    }

    /**
     * Get country code for a given locale from cached data
     */
    public function getCountryCode(string $locale): string
    {
        foreach ($this->allActiveLanguages as $langData) {
            if ($langData['locale'] === $locale) {
                return strtolower($langData['country_code']);
            }
        }
        return strtolower($locale);
    }

    public function startEditing(string $field, string $locale): void
    {
        $key = "{$field}_{$locale}";
        $this->editingStates[$key] = true;
        $this->editingValues[$key] = $this->languages[$field][$locale] ?? '';
    }

    public function cancelEditing(string $field, string $locale): void
    {
        $key = "{$field}_{$locale}";
        unset($this->editingStates[$key]);
        unset($this->editingValues[$key]);
    }

    public function saveTranslation(string $field, string $locale): void
    {
        $key = "{$field}_{$locale}";
        $newValue = trim($this->editingValues[$key] ?? '');

        // Validate that value is not empty
        if (empty($newValue)) {
            $this->dispatch(
                'translation-updated',
                message: 'Translation cannot be empty',
                type: 'error'
            );
            return;
        }

        try {
            $translationModelClass = $this->translationConfig['model'];
            $foreignKey = $this->translationConfig['foreign_key'];
            $fieldMapping = $this->translationConfig['field_mapping'];

            // Get the mapped field name for translation table
            $translationField = $fieldMapping[$field] ?? $field;

            // Find language ID from locale (cached from initial load)
            $language = null;
            foreach ($this->allActiveLanguages as $langData) {
                if ($langData['locale'] === $locale) {
                    // Get language from cache without additional query
                    $language = Language::where('locale', $locale)
                        ->where('status', LanguageStatus::ACTIVE)
                        ->first();
                    break;
                }
            }

            if (!$language) {
                throw new \Exception('Language not found');
            }

            // UpdateOrCreate: single query with transaction
            DB::transaction(function () use ($translationModelClass, $foreignKey, $translationField, $language, $newValue) {
                $translationModelClass::updateOrCreate(
                    [
                        $foreignKey => $this->modelId,
                        'language_id' => $language->id,
                    ],
                    [
                        $translationField => $newValue,
                    ]
                );
            });

            // Update local state
            $this->languages[$field][$locale] = $newValue;

            // Clear editing state
            unset($this->editingStates[$key]);
            unset($this->editingValues[$key]);

            // Show success message
            $this->dispatch(
                'translation-updated',
                message: 'Translation saved successfully!',
                type: 'success'
            );
        } catch (\Exception $e) {
            Log::error('Translation save error: ' . $e->getMessage());

            $this->dispatch(
                'translation-updated',
                message: 'Failed to save translation: ' . $e->getMessage(),
                type: 'error'
            );
        }
    }

    private function getTranslationRelationFromModel(): string
    {
        $tempModel = new $this->modelType();
        return $tempModel->getTranslationConfig()['relation'];
    }

    public function closeModal(): void
    {
        $this->showTranslationDetailsModal = false;
        $this->modelType = null;
        $this->modelId = null;
        $this->translationConfig = [];
        $this->languages = [];
        $this->allActiveLanguages = [];
        $this->editingStates = [];
        $this->editingValues = [];
        $this->selectedLanguage = 'all';
    }
}
