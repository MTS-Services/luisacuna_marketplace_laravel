<?php

namespace App\Services;

use DeepL\Translator;
use DeepL\TranslatorOptions;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class DeepLTranslationServiceForBeta
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

        $options = [
            TranslatorOptions::MAX_RETRIES => 3,
            TranslatorOptions::TIMEOUT => 30,
        ];

        if ($this->isFree) {
            $options[TranslatorOptions::SERVER_URL] = 'https://api-free.deepl.com';
        }

        $this->translator = new Translator($apiKey, $options);
    }

    /**
     * Translate text to a target language
     * 
     * @param string $text Text to translate
     * @param string $targetLang Target language code (e.g., 'ES', 'FR', 'BN')
     * @param string|null $sourceLang Source language (null for auto-detect)
     * @param bool $enableBetaLanguages Enable beta languages (required for Bengali, Hindi, etc.)
     * @return string|null Translated text
     */
    public function translate(
        string $text, 
        string $targetLang, 
        ?string $sourceLang = null,
        bool $enableBetaLanguages = true  // Enable by default
    ): ?string {
        try {
            $cacheKey = $this->getCacheKey($text, $targetLang, $sourceLang);
            
            return Cache::remember($cacheKey, 86400, function () use ($text, $targetLang, $sourceLang, $enableBetaLanguages) {
                // Build options array
                $options = [];
                
                if ($enableBetaLanguages) {
                    $options['enable_beta_languages'] = true;
                }
                
                $result = $this->translator->translateText(
                    $text,
                    $sourceLang,
                    $targetLang,
                    $options  // Pass the options array
                );
                
                return $result->text;
            });
        } catch (\Exception $e) {
            Log::error('DeepL Translation Error', [
                'message' => $e->getMessage(),
                'text' => $text,
                'target' => $targetLang,
                'source' => $sourceLang,
                'beta_enabled' => $enableBetaLanguages
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
     * @param bool $enableBetaLanguages Enable beta languages
     * @return array Array of translated texts
     */
    public function translateBulk(
        array $texts, 
        string $targetLang, 
        ?string $sourceLang = null,
        bool $enableBetaLanguages = true
    ): array {
        try {
            $options = [];
            
            if ($enableBetaLanguages) {
                $options['enable_beta_languages'] = true;
            }
            
            $results = $this->translator->translateText(
                $texts,
                $sourceLang,
                $targetLang,
                $options
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
     * Check if a language is a beta language
     * Beta languages: Bengali, Hindi, Marathi, Tamil, Urdu, Malay, Tagalog, etc.
     */
    public function isBetaLanguage(string $languageCode): bool
    {
        $betaLanguages = [
            'BN',      // Bengali
            'HI',      // Hindi
            'MR',      // Marathi
            'TA',      // Tamil
            'UR',      // Urdu
            'MS',      // Malay
            'TL',      // Tagalog
            'SW',      // Swahili
            'AF',      // Afrikaans
            'MG',      // Malagasy
            'HR',      // Croatian
            'BS',      // Bosnian
            'SR',      // Serbian
        ];
        
        return in_array(strtoupper($languageCode), $betaLanguages);
    }

    /**
     * Get supported target languages (includes beta languages)
     */
    public function getTargetLanguages(bool $includeBeta = true): array
    {
        try {
            $cacheKey = $includeBeta ? 'deepl_target_languages_with_beta' : 'deepl_target_languages';
            
            return Cache::remember($cacheKey, 604800, function () use ($includeBeta) {
                $languages = $this->translator->getTargetLanguages();
                
                $result = array_map(function ($lang) {
                    return [
                        'code' => $lang->code,
                        'name' => $lang->name,
                        'is_beta' => $this->isBetaLanguage($lang->code),
                    ];
                }, $languages);
                
                // If includeBeta is true, add known beta languages that might not be in the API response yet
                if ($includeBeta) {
                    $additionalBetaLanguages = [
                        ['code' => 'BN', 'name' => 'Bengali', 'is_beta' => true],
                        ['code' => 'HI', 'name' => 'Hindi', 'is_beta' => true],
                        ['code' => 'MR', 'name' => 'Marathi', 'is_beta' => true],
                        ['code' => 'TA', 'name' => 'Tamil', 'is_beta' => true],
                        ['code' => 'UR', 'name' => 'Urdu', 'is_beta' => true],
                        ['code' => 'MS', 'name' => 'Malay', 'is_beta' => true],
                        ['code' => 'TL', 'name' => 'Tagalog', 'is_beta' => true],
                    ];
                    
                    // Merge and remove duplicates
                    $existingCodes = array_column($result, 'code');
                    foreach ($additionalBetaLanguages as $betaLang) {
                        if (!in_array($betaLang['code'], $existingCodes)) {
                            $result[] = $betaLang;
                        }
                    }
                }
                
                // Sort by name
                usort($result, function($a, $b) {
                    return strcmp($a['name'], $b['name']);
                });
                
                return $result;
            });
        } catch (\Exception $e) {
            Log::error('DeepL Get Languages Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get supported source languages
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
                        'is_beta' => $this->isBetaLanguage($lang->code),
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

    protected function getCacheKey(string $text, string $targetLang, ?string $sourceLang): string
    {
        return 'deepl_translation_' . md5($text . $targetLang . ($sourceLang ?? 'auto'));
    }

    public function clearCache(): void
    {
        Cache::flush();
    }
}