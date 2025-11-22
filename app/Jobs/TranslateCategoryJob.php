<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Language;
use App\Models\CategoryLanguage;
use App\Services\DeepLTranslationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TranslateCategoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     */
    public int $timeout = 300;

    /**
     * Delete the job if its models no longer exist.
     */
    public bool $deleteWhenMissingModels = true;

    public function __construct(
        public Category $category,
        public ?string $sourceLanguageCode = null,
        public ?array $targetLanguageIds = null // Specific languages to translate to, null = all active
    ) {}

    /**
     * Execute the job.
     */
    public function handle(DeepLTranslationService $translator): void
    {
        Log::info('TranslateCategoryJob started for Category ID: ' . $this->category->id);
        try {
            Log::info('Starting category translation job', [
                'category_id' => $this->category->id,
                'category_name' => $this->category->name,
                'source_language' => $this->sourceLanguageCode
            ]);

            // Get target languages
            $targetLanguages = $this->getTargetLanguages();

            if ($targetLanguages->isEmpty()) {
                Log::warning('No active languages found for translation', [
                    'category_id' => $this->category->id
                ]);
                return;
            }

            // Source language - if not provided, assume English or auto-detect
            $sourceLang = $this->sourceLanguageCode ? strtoupper($this->sourceLanguageCode) : 'EN';

            // Translate to each language
            foreach ($targetLanguages as $language) {
                $this->translateToLanguage($translator, $language, $sourceLang);
            }

            Log::info('Category translation job completed successfully', [
                'category_id' => $this->category->id,
                'languages_processed' => $targetLanguages->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Category translation job failed', [
                'category_id' => $this->category->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e; // Re-throw to trigger retry mechanism
        }
    }

    /**
     * Translate category to a specific language
     */
    protected function translateToLanguage(
        DeepLTranslationService $translator,
        Language $language,
        string $sourceLang
    ): void {
        try {
            $targetLang = $this->mapLanguageCodeToDeepL($language->locale);

            // Skip if source and target are the same
            if (strtoupper($sourceLang) === strtoupper($targetLang)) {
                $this->saveOriginalLanguage($language);
                return;
            }

            Log::info('Translating category to language', [
                'category_id' => $this->category->id,
                'language' => $language->name,
                'target_code' => $targetLang
            ]);

            // Translate the name
            $translatedName = $translator->translate(
                $this->category->name,
                $targetLang,
                $sourceLang
            );

            if (!$translatedName) {
                Log::warning('Translation returned null', [
                    'category_id' => $this->category->id,
                    'language_id' => $language->id,
                    'field' => 'name'
                ]);
                return;
            }

            // Save or update the translation
            $this->saveTranslation($language, $translatedName);

            Log::info('Translation saved successfully', [
                'category_id' => $this->category->id,
                'language_id' => $language->id,
                'original_name' => $this->category->name,
                'translated_name' => $translatedName
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to translate to specific language', [
                'category_id' => $this->category->id,
                'language_id' => $language->id,
                'error' => $e->getMessage()
            ]);

            // Don't throw - continue with other languages
        }
    }

    /**
     * Save translation to category_languages table
     */
    protected function saveTranslation(Language $language, string $translatedName): void
    {
        CategoryLanguage::updateOrCreate(
            [
                'category_id' => $this->category->id,
                'language_id' => $language->id,
            ],
            [
                'name' => $translatedName,
                'sort_order' => 0,
            ]
        );
    }

    /**
     * Save original language (when source and target are same)
     */
    protected function saveOriginalLanguage(Language $language): void
    {
        CategoryLanguage::updateOrCreate(
            [
                'category_id' => $this->category->id,
                'language_id' => $language->id,
            ],
            [
                'name' => $this->category->name,
                'sort_order' => 0,
            ]
        );
    }

    /**
     * Get target languages to translate to
     */
    protected function getTargetLanguages()
    {
        $query = Language::query()->where('status', \App\Enums\LanguageStatus::ACTIVE);

        if ($this->targetLanguageIds) {
            $query->whereIn('id', $this->targetLanguageIds);
        }

        return $query->orderBy('sort_order')->get();
    }

    /**
     * Map your locale codes to DeepL language codes
     * 
     * Your DB uses: 'en', 'es', 'fr', 'bn'
     * DeepL uses: 'EN', 'ES', 'FR', 'BN'
     */
    protected function mapLanguageCodeToDeepL(string $locale): string
    {
        // Language code mapping
        $mapping = [
            'en' => 'EN-US',      // English (American)
            'en-gb' => 'EN-GB',   // English (British)
            'es' => 'ES',         // Spanish
            'fr' => 'FR',         // French
            'de' => 'DE',         // German
            'it' => 'IT',         // Italian
            'pt' => 'PT-PT',      // Portuguese (European)
            'pt-br' => 'PT-BR',   // Portuguese (Brazilian)
            'nl' => 'NL',         // Dutch
            'pl' => 'PL',         // Polish
            'ru' => 'RU',         // Russian
            'ja' => 'JA',         // Japanese
            'zh' => 'ZH',         // Chinese (Simplified)
            'ko' => 'KO',         // Korean
            'tr' => 'TR',         // Turkish
            'ar' => 'AR',         // Arabic
            'bn' => 'BN',         // Bengali
            'hi' => 'HI',         // Hindi
            'ta' => 'TA',         // Tamil
            'ur' => 'UR',         // Urdu
            'id' => 'ID',         // Indonesian
            'th' => 'TH',         // Thai
            'vi' => 'VI',         // Vietnamese
            'sv' => 'SV',         // Swedish
            'da' => 'DA',         // Danish
            'fi' => 'FI',         // Finnish
            'no' => 'NB',         // Norwegian
            'cs' => 'CS',         // Czech
            'el' => 'EL',         // Greek
            'hu' => 'HU',         // Hungarian
            'bg' => 'BG',         // Bulgarian
            'ro' => 'RO',         // Romanian
            'uk' => 'UK',         // Ukrainian
            'he' => 'HE',         // Hebrew
            'ms' => 'MS',         // Malay
            'tl' => 'TL',         // Tagalog
        ];

        $locale = strtolower($locale);

        return strtoupper($mapping[$locale] ?? $locale);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Category translation job permanently failed', [
            'category_id' => $this->category->id,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);

        // You can send notification to admin here if needed
    }
}
