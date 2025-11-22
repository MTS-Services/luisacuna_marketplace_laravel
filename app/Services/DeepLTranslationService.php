<?php

namespace App\Services;

use DeepL\Translator;
use DeepL\TranslatorOptions;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DeepLTranslationService
{
    protected Translator $translator;
    protected bool $isFree;

    public function __construct()
    {
        $apiKey = config('services.deepl.key');
        $this->isFree = config('services.deepl.is_free', false);

        if (!$apiKey) {
            throw new \Exception('DeepL API key is not configured');
        }

        // Configure translator options
        $options = [
            TranslatorOptions::MAX_RETRIES => 3,
            TranslatorOptions::TIMEOUT => 30,
        ];

        // Use different server URL for free vs pro
        if ($this->isFree) {
            $options[TranslatorOptions::SERVER_URL] = 'https://api-free.deepl.com';
        }

        $this->translator = new Translator($apiKey, $options);
    }

    /**
     * Translate text to a target language
     * 
     * @param string $text Text to translate
     * @param string $targetLang Target language code (e.g., 'ES', 'FR', 'DE')
     * @param string|null $sourceLang Source language (null for auto-detect)
     * @return string|null Translated text
     */
    public function translate(
        string $text,
        string $targetLang,
        ?string $sourceLang = null
    ): ?string {
        try {
            // Create cache key
            $cacheKey = $this->getCacheKey($text, $targetLang, $sourceLang);

            // Check cache first (24 hours)
            return Cache::remember($cacheKey, 86400, function () use ($text, $targetLang, $sourceLang) {
                $result = $this->translator->translateText(
                    $text,
                    $sourceLang,
                    $targetLang
                );

                return $result->text;
            });
        } catch (\Exception $e) {
            Log::error('DeepL Translation Error', [
                'message' => $e->getMessage(),
                'text' => $text,
                'target' => $targetLang,
                'source' => $sourceLang
            ]);

            return null;
        }
    }

    /**
     * Translate multiple texts at once (bulk translation)
     * 
     * @param array $texts Array of texts to translate
     * @param string $targetLang Target language code
     * @param string|null $sourceLang Source language
     * @return array Array of translated texts
     */
    public function translateBulk(
        array $texts,
        string $targetLang,
        ?string $sourceLang = null
    ): array {
        try {
            $results = $this->translator->translateText(
                $texts,
                $sourceLang,
                $targetLang
            );

            $translations = [];
            foreach ($results as $result) {
                $translations[] = $result->text;
            }

            return $translations;
        } catch (\Exception $e) {
            Log::error('DeepL Bulk Translation Error', [
                'message' => $e->getMessage(),
                'count' => count($texts),
                'target' => $targetLang
            ]);

            return [];
        }
    }

    /**
     * Get supported target languages
     * 
     * @return array Array of language objects
     */
    public function getTargetLanguages(): array
    {
        try {
            return Cache::remember('deepl_target_languages', 604800, function () {
                $languages = $this->translator->getTargetLanguages();

                return array_map(function ($lang) {
                    return [
                        'code' => $lang->code,
                        'name' => $lang->name,
                    ];
                }, $languages);
            });
        } catch (\Exception $e) {
            Log::error('DeepL Get Languages Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get supported source languages
     * 
     * @return array Array of language objects
     */
    public function getSourceLanguages(): array
    {
        try {
            return Cache::remember('deepl_source_languages', 604800, function () {
                $languages = $this->translator->getSourceLanguages();

                return array_map(function ($lang) {
                    return [
                        'code' => $lang->code,
                        'name' => $lang->name,
                    ];
                }, $languages);
            });
        } catch (\Exception $e) {
            Log::error('DeepL Get Source Languages Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get API usage statistics
     * 
     * @return array|null Usage information
     */
    public function getUsage(): ?array
    {
        try {
            $usage = $this->translator->getUsage();

            return [
                'character_count' => $usage->character->count,
                'character_limit' => $usage->character->limit,
                'usage_percentage' => $usage->character->limit > 0
                    ? round(($usage->character->count / $usage->character->limit) * 100, 2)
                    : 0
            ];
        } catch (\Exception $e) {
            Log::error('DeepL Get Usage Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate cache key for translation
     */
    protected function getCacheKey(string $text, string $targetLang, ?string $sourceLang): string
    {
        return 'deepl_translation_' . md5($text . $targetLang . ($sourceLang ?? 'auto'));
    }

    /**
     * Clear translation cache
     */
    public function clearCache(): void
    {
        Cache::flush();
    }
}
