<?php

namespace App\Traits;

use App\Jobs\TranslateModelJob;

trait HasTranslations
{
    /**
     * Dispatch translation job for this model
     * 
     * @param string $defaultLanguageLocale Default language (will be saved but not translated)
     * @param array|null $targetLanguageIds Specific language IDs (null = all active)
     * @return void
     */
    public function dispatchTranslation(
        string $defaultLanguageLocale = 'en',
        ?array $targetLanguageIds = null
    ): void {
        $config = $this->getTranslationConfig();

        TranslateModelJob::dispatch(
            model: $this,
            translatableFields: $config['fields'],
            translationRelation: $config['relation'],
            translationModelClass: $config['model'],
            foreignKey: $config['foreign_key'],
            fieldMapping: $config['field_mapping'],
            defaultLanguageLocale: $defaultLanguageLocale,
            targetLanguageIds: $targetLanguageIds
        );
    }

    /**
     * Get translation configuration for this model
     * Override this method in your model to customize
     */
    abstract protected function getTranslationConfig(): array;

    /**
     * Get translated value for a specific language
     */
    public function getTranslated(string $field, $languageIdOrLocale): ?string
    {
        $config = $this->getTranslationConfig();
        $relation = $config['relation'];

        if (is_numeric($languageIdOrLocale)) {
            $translation = $this->$relation()
                ->where('language_id', $languageIdOrLocale)
                ->first();
        } else {
            $translation = $this->$relation()
                ->whereHas('language', function ($query) use ($languageIdOrLocale) {
                    $query->where('locale', $languageIdOrLocale);
                })
                ->first();
        }

        $mappedField = $config['field_mapping'][$field] ?? $field;
        return $translation?->$mappedField;
    }

    /**
     * Get all translations for a specific field
     */
    public function getAllTranslationsFor(string $field): array
    {
        $config = $this->getTranslationConfig();
        $relation = $config['relation'];
        $mappedField = $config['field_mapping'][$field] ?? $field;

        return $this->$relation()
            ->with('language')
            ->get()
            ->mapWithKeys(function ($translation) use ($mappedField) {
                return [$translation->language->locale => $translation->$mappedField];
            })
            ->toArray();
    }

    /**
     * Check if translation exists
     */
    public function hasTranslation($languageIdOrLocale): bool
    {
        $config = $this->getTranslationConfig();
        $relation = $config['relation'];

        if (is_numeric($languageIdOrLocale)) {
            return $this->$relation()
                ->where('language_id', $languageIdOrLocale)
                ->exists();
        }

        return $this->$relation()
            ->whereHas('language', function ($query) use ($languageIdOrLocale) {
                $query->where('locale', $languageIdOrLocale);
            })
            ->exists();
    }

    /**
     * Get translation progress
     */
    public function getTranslationProgress(): array
    {
        $config = $this->getTranslationConfig();
        $relation = $config['relation'];

        $totalLanguages = \App\Models\Language::where('status', \App\Enums\LanguageStatus::ACTIVE)->count();
        $translatedCount = $this->$relation()->count();

        return [
            'total' => $totalLanguages,
            'translated' => $translatedCount,
            'percentage' => $totalLanguages > 0 ? round(($translatedCount / $totalLanguages) * 100, 2) : 0,
            'missing' => $totalLanguages - $translatedCount,
        ];
    }
}
