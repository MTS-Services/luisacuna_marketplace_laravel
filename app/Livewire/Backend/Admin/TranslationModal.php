<?php

namespace App\Livewire\Backend\Admin;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class TranslationModal extends Component
{
    public bool $showTranslationDetailsModal = false;
    public array $languages = [];
    public string $selectedLanguage = 'all';
    public ?string $modelType = null;
    public ?string $modelId = null;
    public array $translationConfig = []; // Store config to avoid re-fetching model

    // Track editing states
    public array $editingStates = []; // ['field_lang' => true/false]
    public array $editingValues = []; // ['field_lang' => 'value']

    public function render()
    {
        return view('livewire.backend.admin.translation-modal', [
            'filteredLanguages' => $this->filteredLanguages(),
            'availableLanguages' => $this->getAvailableLanguages(),
        ]);
    }

    #[On('show-translation-modal')]
    public function showTranslationDetailsModal($modelId, $modelType)
    {
        $this->showTranslationDetailsModal = true;
        $this->modelType = base64_decode($modelType);
        $this->modelId = decrypt($modelId);

        // Fetch model with all translations eagerly loaded to prevent N+1
        $model = $this->modelType::with([
            $this->getTranslationRelationFromModel() . '.language'
        ])->findOrFail($this->modelId);

        // Store translation config for later use
        $this->translationConfig = $model->getTranslationConfig();

        // Get all translations in memory
        $this->languages = $model->getTranslatedFields();

        // Reset editing states
        $this->editingStates = [];
        $this->editingValues = [];
    }

    public function filteredLanguages(): array
    {
        if ($this->selectedLanguage === 'all') {
            return $this->languages;
        }

        $filtered = [];
        foreach ($this->languages as $field => $translations) {
            if (isset($translations[$this->selectedLanguage])) {
                $filtered[$field] = [
                    $this->selectedLanguage => $translations[$this->selectedLanguage],
                ];
            }
        }

        return $filtered;
    }

    public function getAvailableLanguages(): array
    {
        $langs = [];
        foreach ($this->languages as $translations) {
            $langs = array_merge($langs, array_keys($translations));
        }
        return array_unique($langs);
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
        $newValue = $this->editingValues[$key] ?? '';

        try {
            // Use stored config instead of calling model method
            $translationRelation = $this->translationConfig['relation'];
            $translationModelClass = $this->translationConfig['model'];
            $foreignKey = $this->translationConfig['foreign_key'];
            $fieldMapping = $this->translationConfig['field_mapping'];

            // Get the mapped field name for translation table
            $translationField = $fieldMapping[$field] ?? $field;

            // Find language ID from locale
            $language = \App\Models\Language::where('locale', $locale)->firstOrFail();

            // Update or create translation - single query
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
            $this->dispatch('translation-updated', [
                'message' => 'Translation updated successfully!',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('translation-updated', [
                'message' => 'Failed to update translation: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    private function getTranslationRelationFromModel(): string
    {
        // Temporarily instantiate model to get config
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
        $this->editingStates = [];
        $this->editingValues = [];
        $this->selectedLanguage = 'all';
    }
}
