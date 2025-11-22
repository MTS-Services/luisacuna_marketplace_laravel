<?php

if (!function_exists('translate_text')) {
    /**
     * Quick helper to translate text
     */
    function translate_text(string $text, string $targetLang, ?string $sourceLang = null): ?string
    {
        $translator = app(\App\Services\DeepLTranslationService::class);
        return $translator->translate($text, $targetLang, $sourceLang);
    }
}

if (!function_exists('get_deepl_languages')) {
    /**
     * Get available DeepL languages
     */
    function get_deepl_languages(): array
    {
        $translator = app(\App\Services\DeepLTranslationService::class);
        return $translator->getTargetLanguages();
    }
}
