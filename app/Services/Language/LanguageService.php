<?php

namespace App\Services\Language;

use App\Models\Language;
use App\DTOs\Language\CreateLanguageDTO;
use App\Actions\Language\CreateLanguageAction;
use App\Repositories\Contracts\LanguageRepositoryInterface;

class LanguageService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected LanguageRepositoryInterface $languageRepository,
        protected CreateLanguageAction $createLanguageAction,
    )
    {}

    public function getLanguages(): array
    {
        return $this->languageRepository->all()->toArray();
    }
    public function createLanguage(CreateLanguageDTO $dto): Language
    {
        return $this->createLanguageAction->execute($dto);
    }
}
