<?php

namespace App\Services;

use App\Models\Language;
use App\DTOs\Language\CreateLanguageDTO;
use App\Actions\Language\CreateLanguageAction;
use App\Repositories\Contracts\LanguageRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class LanguageService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected LanguageRepositoryInterface $interface,
        protected CreateLanguageAction $createLanguageAction,
    )
    {}

    public function getAllDatas(): Collection
    {
        return $this->interface->all();
    }

    public function getLanguages(): array
    {
        return $this->interface->all()->toArray();
    }
    public function createLanguage(CreateLanguageDTO $dto): Language
    {
        return $this->createLanguageAction->execute($dto);
    }
}
