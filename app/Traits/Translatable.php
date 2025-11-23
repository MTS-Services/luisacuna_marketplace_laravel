<?php

namespace App\Traits;

use App\Services\DeepLTranslationService;

trait Translatable
{
    /**
     * Get translatable attributes
     * Override this in your model to specify which fields are translatable
     */
    public function getTranslatableAttributes(): array
    {
        return $this->translatable ?? [];
    }

    /**
     * Translate model attributes to target language
     * 
     * @param string $targetLang DeepL language code
     * @param string|null $sourceLang Source language (null for auto-detect)
     * @return array Translated attributes
     */
    public function translateAttributes(string $targetLang, ?string $sourceLang = null): array
    {
        $translator = app(DeepLTranslationService::class);
        $translatable = $this->getTranslatableAttributes();
        $translations = [];

        foreach ($translatable as $attribute) {
            if ($this->$attribute) {
                $translations[$attribute] = $translator->translate(
                    $this->$attribute,
                    $targetLang,
                    $sourceLang
                );
            }
        }

        return $translations;
    }

    /**
     * Translate and save model to specific language
     * 
     * @param string $targetLang Target language code
     * @param string|null $sourceLang Source language
     * @return bool Success status
     */
    public function translateAndSave(string $targetLang, ?string $sourceLang = null): bool
    {
        $translations = $this->translateAttributes($targetLang, $sourceLang);

        foreach ($translations as $attribute => $value) {
            $this->$attribute = $value;
        }

        return $this->save();
    }
}
