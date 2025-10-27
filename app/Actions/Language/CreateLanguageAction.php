<?php

namespace App\Actions\Language;

use App\Models\Language;
use Illuminate\Support\Facades\DB;
use App\DTOs\Language\CreateLanguageDTO;
use App\Repositories\Contracts\LanguageRepositoryInterface;

class CreateLanguageAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected LanguageRepositoryInterface $languageRepository
    )
    {}

    public function execute(CreateLanguageDTO $dto): Language
    {
        return DB::transaction(function () use ($dto) {
            $data = $dto->toArray();


            // if ($dto->avatar) {
            //     $data['avatar'] = $dto->avatar->store('avatars', 'public');
            // }

            $language = $this->languageRepository->create($data);

            return $language->fresh();
        });
    }
}
