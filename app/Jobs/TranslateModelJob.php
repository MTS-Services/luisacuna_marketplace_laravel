<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Language;
use App\Services\DeepLTranslationService;

class TranslateModelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 300;
    public bool $deleteWhenMissingModels = true;

    /**
     * @param Model $model The model instance to translate
     * @param array $translatableFields Fields to translate ['name', 'description', etc.]
     * @param string $translationRelation Relationship name to store translations (e.g., 'categoryLanguages')
     * @param string $translationModelClass Full class name of translation model (e.g., CategoryLanguage::class)
     * @param string $foreignKey Foreign key in translation table (e.g., 'category_id')
     * @param array $fieldMapping Map model fields to translation table fields ['name' => 'name', 'description' => 'description']
     * @param string $defaultLanguageLocale Default language to skip (e.g., 'en')
     * @param array|null $targetLanguageIds Specific language IDs to translate to (null = all active except default)
     */
    public function __construct(
        public Model $model,
        public array $translatableFields,
        public string $translationRelation,
        public string $translationModelClass,
        public string $foreignKey,
        public array $fieldMapping,
        public string $defaultLanguageLocale = 'en',
        public ?array $targetLanguageIds = null
    ) {}

    public function handle(DeepLTranslationService $translator): void
    {
        try {
            Log::info('🚀 TranslateModelJob STARTED', [
                'model' => get_class($this->model),
                'model_id' => $this->model->id,
                'fields' => $this->translatableFields,
                'default_language' => $this->defaultLanguageLocale
            ]);

            // Get target languages (exclude default language)
            $targetLanguages = $this->getTargetLanguages();

            if ($targetLanguages->isEmpty()) {
                Log::warning('No target languages found for translation', [
                    'model' => get_class($this->model),
                    'model_id' => $this->model->id
                ]);
                return;
            }

            // Get default language to save original content
            $defaultLanguage = Language::where('locale', $this->defaultLanguageLocale)
                ->where('status', \App\Enums\LanguageStatus::ACTIVE)
                ->first();

            // Save original content in default language (no translation needed)
            if ($defaultLanguage) {
                $this->saveOriginalLanguage($defaultLanguage);
            }

            // Source language code for DeepL (uppercase)
            $sourceLang = strtoupper($this->defaultLanguageLocale);

            // Translate to each target language
            $successCount = 0;
            foreach ($targetLanguages as $language) {
                $success = $this->translateToLanguage($translator, $language, $sourceLang);
                if ($success) {
                    $successCount++;
                }
            }

            Log::info('✅ TranslateModelJob COMPLETED', [
                'model' => get_class($this->model),
                'model_id' => $this->model->id,
                'total_languages' => $targetLanguages->count(),
                'successful_translations' => $successCount
            ]);
        } catch (\Exception $e) {
            Log::error('❌ TranslateModelJob FAILED', [
                'model' => get_class($this->model),
                'model_id' => $this->model->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Translate model to a specific language
     */
    protected function translateToLanguage(
        DeepLTranslationService $translator,
        Language $language,
        string $sourceLang
    ): bool {
        try {
            $targetLang = $this->mapLanguageCodeToDeepL($language->locale);

            Log::info('Translating model to language', [
                'model' => get_class($this->model),
                'model_id' => $this->model->id,
                'language' => $language->name,
                'target_code' => $targetLang,
                'source_code' => $sourceLang
            ]);

            $translatedData = [];

            // Translate each field
            foreach ($this->translatableFields as $field) {
                $originalValue = $this->model->$field;

                // Skip empty fields
                if (empty($originalValue)) {
                    Log::debug("Skipping empty field: {$field}");
                    continue;
                }

                // Translate
                $translatedValue = $translator->translate(
                    $originalValue,
                    $targetLang,
                    $sourceLang
                );

                if (!$translatedValue) {
                    Log::warning('Translation returned null', [
                        'model' => get_class($this->model),
                        'model_id' => $this->model->id,
                        'language_id' => $language->id,
                        'field' => $field
                    ]);
                    continue;
                }

                // Map to translation table field name
                $translationField = $this->fieldMapping[$field] ?? $field;
                $translatedData[$translationField] = $translatedValue;

                Log::debug('Field translated', [
                    'field' => $field,
                    'original' => substr($originalValue, 0, 50) . '...',
                    'translated' => substr($translatedValue, 0, 50) . '...'
                ]);
            }

            // Save translation
            if (!empty($translatedData)) {
                $this->saveTranslation($language, $translatedData);

                Log::info('Translation saved successfully', [
                    'model' => get_class($this->model),
                    'model_id' => $this->model->id,
                    'language_id' => $language->id,
                    'fields_translated' => array_keys($translatedData)
                ]);

                return true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('Failed to translate to specific language', [
                'model' => get_class($this->model),
                'model_id' => $this->model->id,
                'language_id' => $language->id,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Save translation to database
     */
    protected function saveTranslation(Language $language, array $translatedData): void
    {
        $translationModel = $this->translationModelClass;

        $translationModel::updateOrCreate(
            [
                $this->foreignKey => $this->model->id,
                'language_id' => $language->id,
            ],
            array_merge($translatedData, [
                'sort_order' => 0,
            ])
        );
    }

    /**
     * Save original content in default language (no translation)
     */
    protected function saveOriginalLanguage(Language $language): void
    {
        Log::info('Saving original content in default language', [
            'model' => get_class($this->model),
            'model_id' => $this->model->id,
            'language' => $language->name,
            'locale' => $language->locale
        ]);

        $originalData = [];

        foreach ($this->translatableFields as $field) {
            $originalValue = $this->model->$field;

            if (!empty($originalValue)) {
                $translationField = $this->fieldMapping[$field] ?? $field;
                $originalData[$translationField] = $originalValue;
            }
        }

        if (!empty($originalData)) {
            $translationModel = $this->translationModelClass;

            $translationModel::updateOrCreate(
                [
                    $this->foreignKey => $this->model->id,
                    'language_id' => $language->id,
                ],
                array_merge($originalData, [
                    'sort_order' => 0,
                ])
            );

            Log::info('Original content saved (no translation needed)', [
                'model' => get_class($this->model),
                'model_id' => $this->model->id,
                'language_id' => $language->id
            ]);
        }
    }

    /**
     * Get target languages (exclude default language)
     */
    protected function getTargetLanguages()
    {
        $query = Language::query()
            ->where('status', \App\Enums\LanguageStatus::ACTIVE)
            ->where('locale', '!=', $this->defaultLanguageLocale); // Skip default language

        if ($this->targetLanguageIds) {
            $query->whereIn('id', $this->targetLanguageIds);
        }

        return $query->orderBy('sort_order')->get();
    }

    /**
     * Map locale codes to DeepL language codes
     */
    protected function mapLanguageCodeToDeepL(string $locale): string
    {
        $mapping = [
            'en' => 'EN-US',
            'en-gb' => 'EN-GB',
            'es' => 'ES',
            'fr' => 'FR',
            'de' => 'DE',
            'it' => 'IT',
            'pt' => 'PT-PT',
            'pt-br' => 'PT-BR',
            'nl' => 'NL',
            'pl' => 'PL',
            'ru' => 'RU',
            'ja' => 'JA',
            'zh' => 'ZH',
            'ko' => 'KO',
            'tr' => 'TR',
            'ar' => 'AR',
            'bn' => 'BN',
            'hi' => 'HI',
            'ta' => 'TA',
            'ur' => 'UR',
            'id' => 'ID',
            'th' => 'TH',
            'vi' => 'VI',
            'sv' => 'SV',
            'da' => 'DA',
            'fi' => 'FI',
            'no' => 'NB',
            'cs' => 'CS',
            'el' => 'EL',
            'hu' => 'HU',
            'bg' => 'BG',
            'ro' => 'RO',
            'uk' => 'UK',
            'he' => 'HE',
            'ms' => 'MS',
            'tl' => 'TL',
        ];

        $locale = strtolower($locale);
        return strtoupper($mapping[$locale] ?? $locale);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('TranslateModelJob permanently failed', [
            'model' => get_class($this->model),
            'model_id' => $this->model->id,
            'error' => $exception->getMessage()
        ]);
    }
}
